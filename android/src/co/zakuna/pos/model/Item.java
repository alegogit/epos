package co.zakuna.pos.model;

import lombok.*;
import com.j256.ormlite.field.DatabaseField;
import com.j256.ormlite.table.DatabaseTable;

@Data
@DatabaseTable(tableName = "item")
public class Item extends TimeBase {
	@DatabaseField
	private Category category;

	@DatabaseField
	private String name;

	@DatabaseField
	private Double price;

	@DatabaseField(columnName = "current_quantity")
	private Integer currentQty;

	@DatabaseField
	private Integer printer;

	@DatabaseField
	private Integer tax;
}
