package co.zakuna.pos.model;

import lombok.*;
import com.j256.ormlite.field.DatabaseField;
import com.j256.ormlite.table.DatabaseTable;

@Data
@DatabaseTable(tableName = "customer")
public class Customer extends TimeBase {
	@DatabaseField
	private String name;

	@DatabaseField		
	private String telphone;
	
	@DatabaseField(columnName = "address_line_1")
	private String addressLine1;
	
	@DatabaseField(columnName = "address_line_2")
	private String addressLine2;
	
	@DatabaseField
	private String city;
	
	@DatabaseField(columnName = "email_address")
	private String emailAddress;
}
