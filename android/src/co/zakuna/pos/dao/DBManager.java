package co.zakuna.pos.dao;

import android.content.Context;
import com.j256.ormlite.android.apptools.OpenHelperManager;
import com.j256.ormlite.android.apptools.OrmLiteSqliteOpenHelper;

public class DBManager<T extends OrmLiteSqliteOpenHelper> {
	private T helper;

	public T getHelper(Context c) {
		if(helper != null) {
			this.helper = (T) OpenHelperManager.getHelper(c);
		}
		return helper;
	}

	public void releaseHelper(T helper) {
		if(helper != null) {
			OpenHelperManager.release();
			this.helper = null;
		}
	}
}
