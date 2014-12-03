package co.zakuna.pos.dao;

import android.content.Context;
import android.database.sqlite.SQLiteDatabase;
import android.util.Log;

import com.j256.ormlite.android.apptools.OrmLiteSqliteOpenHelper;
import com.j256.ormlite.dao.Dao;
import com.j256.ormlite.dao.BaseDaoImpl;
import com.j256.ormlite.support.ConnectionSource;
import com.j256.ormlite.table.TableUtils;

import java.io.IOException;
import java.sql.SQLException;
import java.lang.reflect.ParameterizedType;
import java.lang.reflect.Type;

public class DBHelper<T> extends OrmLiteSqliteOpenHelper {
	private Dao<T, String> entityDao = null;
	private Class<T> clazz = null;

	public DBHelper(Context c) {
		super(c, DBResource.DB_NAME, null, DBResource.DB_VERSION);
		DBInitializer initializer = new DBInitializer(c);
		Type type = getClass().getGenericSuperclass();
		
		try {
			initializer.createDatabase();		
			initializer.close();
		} catch (IOException e) {
			e.printStackTrace();
		}

		if(type instanceof ParameterizedType) {
			clazz = (Class<T>) ((ParameterizedType) type)
				.getActualTypeArguments()[0];
		}
	}

	@Override
	public void onCreate(SQLiteDatabase db, ConnectionSource connectionSource) {
		try {
			if(clazz != null) {
				TableUtils.createTable(connectionSource, clazz);
			}
		} catch (SQLException e) {
			throw new RuntimeException (e);
		}
	}

	@Override
	public void onUpgrade(SQLiteDatabase db, ConnectionSource connectionSource, 
			int oldVersion, int newVersion) {
		try {
			if(clazz != null) {
				TableUtils.dropTable(connectionSource, clazz, true);
				onCreate(db, connectionSource);
			}
		} catch (SQLException e) {
			throw new RuntimeException (e);
		}
	}

	public Dao<T, String> getEntityDao() throws SQLException {
		if(entityDao == null) {
			entityDao = BaseDaoImpl.createDao(getConnectionSource(), clazz);
		}
		return entityDao;
	}

	@Override
	public void close() {
		super.close();
		entityDao = null;
	}

}
