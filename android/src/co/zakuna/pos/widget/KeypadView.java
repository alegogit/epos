package co.zakuna.pos.widget;

import android.annotation.SuppressLint;
import android.app.Activity;
import android.inputmethodservice.Keyboard;
import android.inputmethodservice.KeyboardView;
import android.inputmethodservice.KeyboardView.OnKeyboardActionListener;
import android.text.Editable;
import android.text.InputType;
import android.view.MotionEvent;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.View.OnFocusChangeListener;
import android.view.View.OnTouchListener;
import android.view.WindowManager;
import android.view.inputmethod.InputMethodManager;
import android.widget.EditText;

@SuppressLint("ClickableViewAccessibility") 
public class KeypadView implements OnKeyboardActionListener {
	private final static int CodeDelete = -5;
	private final static int CodeEnter = 0;
	private final KeyboardView mKeyboardView;
	private final Activity mHostActivity;

	private EditText edittext;
	private OnEnterKey listener;

	public interface OnEnterKey {
		public void runEnter();
	}
	
	public void setOnEnterKey(OnEnterKey listener) {
		this.listener = listener;
	}

    public KeypadView(Activity mHostActivity, KeyboardView mKeyboardView, int layoutid) {
        this.mHostActivity= mHostActivity;
        this.mKeyboardView = mKeyboardView;
        this.mKeyboardView.setKeyboard(new Keyboard(mHostActivity, layoutid));
        this.mKeyboardView.setPreviewEnabled(false);
        this.mKeyboardView.setOnKeyboardActionListener(KeypadView.this);
        this.mHostActivity.getWindow().setSoftInputMode(
        		WindowManager.LayoutParams.SOFT_INPUT_STATE_ALWAYS_HIDDEN);
    }
    
    @Override 
    public void onKey(int primaryCode, int[] keyCodes) {
        Editable editable = edittext.getText();
        int start = edittext.getSelectionStart();

        if( primaryCode==CodeEnter ) {
        	if(listener instanceof OnEnterKey) listener.runEnter();
        } else if( primaryCode==CodeDelete ) {
            if( editable!=null && start>0 ) editable.delete(start - 1, start);
        } else {
            editable.insert(start, Character.toString((char) primaryCode));
        }
    }

    @Override public void onPress(int arg0) {}
    @Override public void onRelease(int primaryCode) {}
    @Override public void onText(CharSequence text) {}
    @Override public void swipeDown() {}
    @Override public void swipeLeft() {}
    @Override public void swipeRight() {}
    @Override public void swipeUp() {}

    public boolean isCustomKeyboardVisible() {
        return mKeyboardView.getVisibility() == View.VISIBLE;
    }

    public void showCustomKeyboard( View v ) {
        mKeyboardView.setVisibility(View.VISIBLE);
        mKeyboardView.setEnabled(true);
        if( v!=null ) ((InputMethodManager) mHostActivity.getSystemService(
        		Activity.INPUT_METHOD_SERVICE)).hideSoftInputFromWindow(v.getWindowToken(), 0);
    }

    public void hideCustomKeyboard() {
        mKeyboardView.setVisibility(View.GONE);
        mKeyboardView.setEnabled(false);
    }

    public void registerEditText(EditText edittext) {
    	this.edittext = edittext;
    	this.edittext.setOnFocusChangeListener(new OnFocusChangeListener() {
            @Override 
            public void onFocusChange(View v, boolean hasFocus) {
                if( hasFocus ) showCustomKeyboard(v); else hideCustomKeyboard();
            }
        });
    	this.edittext.setOnClickListener(new OnClickListener() {
            @Override 
            public void onClick(View v) {
                showCustomKeyboard(v);
            }
        });

    	this.edittext.setOnTouchListener(new OnTouchListener() {
            @Override 
            public boolean onTouch(View v, MotionEvent event) {
                EditText edittext = (EditText) v;
                int inType = edittext.getInputType();       
            
                edittext.setInputType(InputType.TYPE_NULL); 
                edittext.onTouchEvent(event);               
                edittext.setInputType(inType);              
                return true; 
            }
        });
    	this.edittext.setInputType(this.edittext.getInputType() 
    		| InputType.TYPE_TEXT_FLAG_NO_SUGGESTIONS
    	);
    }

}
