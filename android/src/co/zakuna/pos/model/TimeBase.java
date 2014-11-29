package co.zakuna.pos.model;

import lombok.*;
import java.util.Date;
import com.j256.ormlite.field.DatabaseField;

@Data
public class TimeBase {
	@DatabaseField(id = true)
	private Long id;

	@DatabaseField(columnName = "created_by")
	private Integer createdBy;
	
	@DatabaseField(columnName = "created_date")
	private Date createdDate;
	
	@DatabaseField(columnName = "last_updated_by")
	private Integer lastUpdatedBy;
	
	@DatabaseField(columnName = "last_update_date")
	private Date lasUpdatedDate;
}
