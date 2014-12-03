package co.zakuna.pos.engine;

import java.lang.reflect.ParameterizedType;
import java.lang.reflect.Type;
import java.util.Collections;

import org.springframework.http.HttpEntity;
import org.springframework.http.HttpHeaders;
import org.springframework.http.HttpMethod;
import org.springframework.http.MediaType;
import android.app.Activity;

public class NetworkGet<T> extends NetworkBase<T> {
	private HttpEntity<?> requestEntity;
	private Class<T> tclass;
	private String token;

	public NetworkGet(Activity activity) {
		super(activity);
		Type type = getClass().getGenericSuperclass();
		if (type instanceof ParameterizedType) {
			this.tclass = (Class<T>) ((ParameterizedType) type)
					.getActualTypeArguments()[0];
		}
	}

	public NetworkGet(Activity activity, String token) {
		this(activity);
		this.token = token;
	}

	@Override
	protected void showProgress() {
	}

	@Override
	protected void dismissProgress() {
	}

	@Override
	protected void setHeaders(HttpHeaders requestHeaders) {
		if (token != null)
			requestHeaderToken(requestHeaders, token);
		requestHeaders.setAccept(Collections.singletonList(new MediaType(
				"application", "json")));
		requestEntity = new HttpEntity<Object>(requestHeaders);
	}

	@Override
	protected T executeRequest(String url) {
		return new BaseRestTemplate().exchange(url, HttpMethod.GET,
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
