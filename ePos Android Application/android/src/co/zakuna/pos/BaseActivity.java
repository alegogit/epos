package co.zakuna.pos;

import android.support.v7.app.ActionBarActivity;
import org.androidannotations.annotations.*;

@EActivity
public class BaseActivity extends ActionBarActivity {
	@AfterViews
	protected void initialized() {
	}
}
