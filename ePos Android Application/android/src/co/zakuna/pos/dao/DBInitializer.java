package co.zakuna.pos.dao;

import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import android.content.Context;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteException;
import android.database.sqlite.SQLiteOpenHelper;

import co.zakuna.pos.R;

public class DBInitializer extends SQLiteOpenHelper {
	private SQLiteDatabase database;
	private final Context context;

	public DBInitializer(Context c) {
		super(c, DBResource.DB_NAME, null, DBResource.DB_VERSION);
		this.context =  c;
	}

	public void createDatabase() throws IOException {
		boolean dbExist = isDatabase();
		if(!dbExist) {
			this.getReadableDatabase();
			try {
				copyDatabase();
			} catch (IOException e) {
				throw new Error(context.getString(R.string.error_db_copy));
			}
		}
	}

	private boolean isDatabase() {
		SQLiteDatabase checkDB = null;
		try {
			String path = DBResource.DB_PATH + DBResource.DB_NAME;
			checkDB = SQLiteDatabase.openDatabase(path, null, SQLiteDatabase.OPEN_READONLY);
		} catch (SQLiteException e) {
			throw new Error(context.getString(R.string.error_db_null));
		}

		if(checkDB != null) {
			checkDB.close();
		}
		return checkDB != null ? true : false;
	}

	private void copyDatabase() throws IOException {
		InputStream input = context.getAssets().open(DBResource.DB_NAME);
		String outputPath = DBResource.DB_PATH + DBResource.DB_NAME;
		OutputStream output = new FileOutputStream(outputPath);

		byte[] buffer = new byte[1024];
		int length;

		while((length = input.read(buffer)) > 0) {
			output.write(buffer, 0, length);
		}
		
		output.flush();
		output.close();
		input.close();
	}

	@Override
	public synchronized void close() {
		if(database != null) {
			database.close();
		}
		super.close();
	}

	@Override
	public void onCreate(SQLiteDatabase db) {
	}

	@Override
	public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion) {
	}

}
