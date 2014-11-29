package co.zakuna.pos.engine;

import java.lang.reflect.ParameterizedType;
import java.lang.reflect.Type;

import org.springframework.http.HttpEntity;
import org.springframework.http.HttpHeaders;
import org.springframework.http.HttpMethod;
import org.springframework.http.MediaType;
import android.app.Activity;

public class NetworkJson<T, E> extends NetworkBase<T> {
	private E object;
	private HttpEntity<E> requestEntity;
	private Class<T> tclass;
	private String token;

	public NetworkJson(Activity activity) {
		super(activity);
		Type type = getClass().getGenericSuperclass();
		if (type instanceof ParameterizedType) {
			this.tclass = (Class<T>) ((ParameterizedType) type)
					.getActualTypeArguments()[0];
		}
	}

	public NetworkJson(Activity activity, E object) {
		this(activity);
		this.object = object;
	}

	public NetworkJson(Activity activity, E object, String token) {
		this(activity, object);
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
		requestHeaders.setContentType(new MediaType("application", "json"));
		requestEntity = new HttpEntity<E>(object, requestHeaders);
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
