package co.zakuna.pos.model;

import lombok.*;
import com.j256.ormlite.field.DatabaseField;
import com.j256.ormlite.table.DatabaseTable;

@Data
@DatabaseTable(tableName = "tables")
public class Tables extends TimeBase {
	@DatabaseField(columnName = "table_number")
	private String tableNumber;
	@DatabaseField
	private Integer position;
}
