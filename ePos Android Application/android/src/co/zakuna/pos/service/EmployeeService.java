package co.zakuna.pos.service;

import co.zakuna.pos.model.Employee;
import co.zakuna.pos.dao.DBHelper;

import com.j256.ormlite.dao.Dao;
import com.j256.ormlite.stmt.PreparedQuery;
import com.j256.ormlite.stmt.QueryBuilder;

import java.sql.SQLException;
import java.util.List;

public class EmployeeService {
	private Dao<Employee, String> empDao;

	public EmployeeService(DBHelper helper) {
		try {
			empDao = helper.getEntityDao();
		} catch (SQLException e) {
			e.printStackTrace();
		}
	}

	public int create(Employee emp) {
		try {
			return empDao.create(emp);
		} catch (SQLException e) {
			e.printStackTrace();
		}
		return 0;
	}

	public int update(Employee emp) {
		try {
			return empDao.update(emp);
		} catch (SQLException e) {
			e.printStackTrace();
		}
		return 0;
	}

	public int delete(Employee emp) {
		try {
			return empDao.delete(emp);
		} catch (SQLException e) {
			e.printStackTrace();
		}
		return 0;
	}

	public List<Employee> getListEmployee() {
		try {
			return empDao.queryForAll();
		} catch (SQLException e) {
			e.printStackTrace();
		}
		return null;
	}

	public Employee getByValue(String key, String value) {
		try {
			QueryBuilder<Employee, String> query = empDao.queryBuilder();
			query.where().eq(key, value);

			PreparedQuery<Employee> pquery = query.prepare();
			return empDao.queryForFirst(pquery);
		} catch (SQLException e) {
			e.printStackTrace();
		}
		return null;
	}

}
