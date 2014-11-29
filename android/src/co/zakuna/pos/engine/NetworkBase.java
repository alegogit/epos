package co.zakuna.pos.engine;

import org.springframework.web.client.ResourceAccessException;
import org.springframework.http.HttpHeaders;
import org.springframework.http.converter.HttpMessageNotReadableException;
import org.springframework.web.client.HttpClientErrorException;
import org.springframework.web.client.RestClientException;
import org.springframework.web.client.HttpServerErrorException;

import android.app.Activity;
import android.content.Intent;
import android.content.pm.PackageInfo;
import android.content.pm.PackageManager.NameNotFoundException;
import android.os.AsyncTask;
import android.util.Log;

import java.lang.ref.WeakReference;
import java.util.HashMap;

public abstract class NetworkBase<E> extends AsyncTask<String, Void, E> {
	protected WeakReference<Activity> activity;
	private final String TAG_HEADER = "Header.Request";
	private final String TAG_ERR = "Application.Error";

	private final String APP_VERS = "app version";
	private final String APP_PLATFORM = "platform";
	private final String APP_TOKEN = "access-token";

	public NetworkBase(Activity act) {
		activity = new WeakReference<Activity>(act);
	}

	@Override
	protected void onPreExecute() {
		if (activity.get() != null && !activity.get().isFinishing())
			showProgress();
		super.onPreExecute();
	}

	@Override
	protected E doInBackground(String... params) {
		final String url = params[0];
		final HttpHeaders requestHeaders = new HttpHeaders();

		// sending header
		requestHeaders.set(APP_PLATFORM, getDevice().get(APP_PLATFORM));
		requestHeaders.set(APP_VERS, getDevice().get(APP_VERS));
		Log.i(TAG_HEADER, requestHeaders.toString());
		setHeaders(requestHeaders);

		try {
			return executeRequest(url);

		} catch (HttpClientErrorException e) {
			setThreadui(e.getMessage(), e);
			return null;

		} catch (ResourceAccessException e) {
			setThreadui(e.getMessage(), e);
			return null;

		} catch (HttpServerErrorException e) { // 500 Internal Server Error
			setThreadui(e.getMessage(), e);
			return null;

		} catch (IllegalArgumentException e) {
			setThreadui(e.getMessage(), e);
			return null;

		} catch (RestClientException e) {
			setThreadui(e.getMessage(), e);
			return null;

		} catch (HttpMessageNotReadableException e) {
			setThreadui(e.getMessage(), e);
			return null;

		} catch (IllegalStateException e) {
			setThreadui(e.getMessage(), e);
			return null;
		}
	}

	@Override
	protected void onPostExecute(final E result) {
		try {
			dismissProgress();
			showResponseServer(result);
		} catch (NullPointerException e) {
			setThreadui(e.getMessage(), e);
		}
		super.onPostExecute(result);
	}

	@Override
	protected void onCancelled() {
		dismissProgress();
	}

	protected abstract void setHeaders(HttpHeaders requestHeaders);

	protected abstract E executeRequest(String url);

	protected abstract Object showResponseServer(E result);

	protected abstract void showProgress();

	protected abstract void dismissProgress();

	protected void requestHeaderToken(HttpHeaders requestHeaders,
			String... token) {
		if (token[0] != null)
			requestHeaders.set(APP_TOKEN, token[0]);
		Log.i(TAG_HEADER, requestHeaders.toString());
	}

	private HashMap<String, String> getDevice() {
		try {
			PackageInfo pInfo = activity.get().getPackageManager()
					.getPackageInfo(activity.get().getPackageName(), 0);
			String version = String.valueOf(pInfo.versionName);
			HashMap<String, String> map = new HashMap<String, String>();
			map.put(APP_PLATFORM, "android");
			map.put(APP_VERS, version);
			return map;

		} catch (NameNotFoundException e) {
			return null;
		}
	}

	private void setThreadui(final String error, final Throwable e) {
		activity.get().runOnUiThread(new Runnable() {
			@Override
			public void run() {
				dismissProgress();
				Log.e(TAG_ERR, error);
			}
		});
	}

}
