package co.zakuna.pos.model;

import lombok.*;
import java.util.List;
import com.j256.ormlite.field.DatabaseField;
import com.j256.ormlite.table.DatabaseTable;

@Data
@DatabaseTable(tableName = "order_details")
public class OrderDetails extends TimeBase {
	@DatabaseField
	private List<Orders> orders;

	@DatabaseField
	private List<Item> items;

	@DatabaseField
	private Integer rank;

	@DatabaseField(columnName = "quantity")
	private Integer qty;

	@DatabaseField(columnName = "kitchen_note")
	private String kitchenNote;

	@DatabaseField
	private boolean wait;

	@DatabaseField
	private Double price;

	@DatabaseField
	private boolean ordered;

	@DatabaseField(columnName = "order_void")
	private boolean orderVoid;

	@DatabaseField(columnName = "order_void_reason")
	private String orderVoidReason;
}
