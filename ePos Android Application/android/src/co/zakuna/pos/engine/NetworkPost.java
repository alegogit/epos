package co.zakuna.pos.engine;

import java.lang.reflect.ParameterizedType;
import java.lang.reflect.Type;

import org.springframework.http.HttpEntity;
import org.springframework.http.HttpHeaders;
import org.springframework.http.HttpMethod;
import org.springframework.http.MediaType;
import org.springframework.util.MultiValueMap;

import android.app.Activity;

public class NetworkPost<T> extends NetworkBase<T> {
	private MultiValueMap<String, String> formData;
	private HttpEntity<?> requestEntity;
	private Class<T> tclass;

	public NetworkPost(Activity activity) {
		super(activity);
		Type type = getClass().getGenericSuperclass();
		if (type instanceof ParameterizedType) {
			this.tclass = (Class<T>) ((ParameterizedType) type)
					.getActualTypeArguments()[0];
		}
	}

	public NetworkPost(Activity activity, MultiValueMap<String, String> formData) {
		this(activity);
		this.formData = formData;
	}

	@Override
	protected void showProgress() {
	}

	@Override
	protected void dismissProgress() {
	}

	@Override
	protected void setHeaders(HttpHeaders requestHeaders) {
		requestHeaderToken(requestHeaders);
		requestHeaders.setContentType(MediaType.APPLICATION_FORM_URLENCODED);
		requestEntity = new HttpEntity<MultiValueMap<String, String>>(formData,
				requestHeaders);
	}

	@Override
	protected T executeRequest(String url) {
		return new BaseRestTemplate(true).exchange(url, HttpMethod.POST,
				requestEntity, tclass).getBody();
	}

	@Override
	protected Object showResponseServer(T result) {
		if (result == null)
			return null;
		else {
			return (Object) result;
		}
	}

}
