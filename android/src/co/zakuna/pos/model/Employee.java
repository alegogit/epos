package co.zakuna.pos.model;

import lombok.*;
import java.util.List;
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
	private List<Role> roles;
}
