package co.zakuna.pos.model;

import lombok.*;
import java.util.List;
import java.util.Date;
import com.j256.ormlite.field.DatabaseField;
import com.j256.ormlite.table.DatabaseTable;

@Data
@DatabaseTable(tableName = "orders")
public class Orders extends TimeBase {
	@DatabaseField
	private List<Tables> tables;

	@DatabaseField
	private List<Customer> customers;

	@DatabaseField
	private Date started;

	@DatabaseField
	private Date ended;

	@DatabaseField
	private boolean active;

	@DatabaseField(columnName = "no_of_guest")
	private Integer noOfGuest;

	@DatabaseField
	private Double total;

	@DatabaseField(columnName = "paid_amount")
	private Double paidAmount;

	@DatabaseField(columnName = "payment_method")
	private String paymentMethod;

	@DatabaseField
	private Double tip;

	@DatabaseField
	private Double discount;
}
