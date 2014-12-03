package co.zakuna.pos.model;

import lombok.*;
import com.j256.ormlite.field.DatabaseField;
import com.j256.ormlite.table.DatabaseTable;

@Data
@DatabaseTable(tableName = "ref_values")
public class RefValues extends TimeBase {
	@DatabaseField
	private String code;

	@DatabaseField
	private String value;

	@DatabaseField
	private String description;
}
