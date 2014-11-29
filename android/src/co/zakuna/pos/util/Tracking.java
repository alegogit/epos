package co.zakuna.pos.util;

import android.content.Context;

import java.io.StringWriter;
import java.io.PrintWriter;

import com.google.analytics.tracking.android.MapBuilder;
import com.google.analytics.tracking.android.EasyTracker;

public class Tracking {
	private Context context;

	public Tracking(Context context) {
		this.context = context;
	}

	public void setEvent(String kategori, String event, String label, Long value) {
		EasyTracker easyTracker = EasyTracker.getInstance(context);
		easyTracker.send(MapBuilder.createEvent(category, // category
				event, // event
				label, // label
				value).build());
	}

	public static String getStackTrace(Throwable t) {
		StringWriter stringWritter = new StringWriter();
		PrintWriter printWritter = new PrintWriter(stringWritter, true);
		t.printStackTrace(printWritter);
		printWritter.flush();
		stringWritter.flush();

		return stringWritter.toString();
	}

}
