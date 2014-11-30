package co.zakuna.pos.model;

import lombok.*;
import com.j256.ormlite.field.DatabaseField;
import com.j256.ormlite.table.DatabaseTable;

@Data
@DatabaseTable(tableName = "employee")
public class Employee extends TimeBase {
	@DatabaseField
	private String name;

	@DatabaseField
	private String username;

	@DatabaseField
	private String password;

	@DatabaseField
	private Role role;
}
