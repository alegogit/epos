package co.zakuna.pos.model;

import lombok.*;
import com.j256.ormlite.field.DatabaseField;
import com.j256.ormlite.table.DatabaseTable;

@Data
@DatabaseTable(tableName = "printer")
public class Printer extends TimeBase {
	@DatabaseField
	private String name;

	@DatabaseField(columnName = "printer_connection")
	private String printerConnection;

	@DatabaseField(columnName = "printer_ip_address")
	private Integer printerIpAddress;

	@DatabaseField(columnName = "printer_port")
	private String printerPort;
}
