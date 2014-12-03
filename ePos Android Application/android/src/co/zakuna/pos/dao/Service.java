package co.zakuna.pos.dao;

import android.content.Context;
import co.zakuna.pos.service.EmployeeService;

import lombok.*;

public class Service<T> {
	private DBHelper<T> db;
	@Getter private EmployeeService employee;

	public Service(Context c) {
		DBManager<DBHelper<T>> manager = new DBManager<DBHelper<T>>();
		this.db = manager.getHelper(c);
		this.employee = new EmployeeService(db);
	}

}
