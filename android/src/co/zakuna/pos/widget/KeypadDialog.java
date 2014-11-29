package co.zakuna.pos.widget;

import lombok.Getter;

import co.zakuna.pos.R;
import co.zakuna.pos.widget.FontUtil.Font;
import co.zakuna.pos.widget.KeypadView.OnEnterKey;

import android.app.Activity;
import android.app.Dialog;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.text.Editable;
import android.text.TextWatcher;
import android.view.Window;
import android.view.WindowManager;
import android.graphics.drawable.ColorDrawable;
import android.inputmethodservice.KeyboardView;
import android.view.View;

public abstract class KeypadDialog implements View.OnClickListener, OnEnterKey,
		TextWatcher {

	private final Dialog dialog;
	private final TextView mExit;
	private final TextView header;
	private final EditText mEditPin;
	private final KeyboardView mKeyboardView;
	private final KeypadView mKeypadView;

	@Getter
	private String value;

	protected abstract void setCancel();

	protected abstract void executeEnter(Object object);

	public KeypadDialog(Activity activity, String messageHeader) {
		dialog = new Dialog(activity);
		dialog.requestWindowFeature(Window.FEATURE_NO_TITLE);
		dialog.getWindow().getAttributes().windowAnimations = R.style.dialog_animation;
		dialog.getWindow().setBackgroundDrawable(
				new ColorDrawable(android.graphics.Color.TRANSPARENT));
		dialog.getWindow().setSoftInputMode(
				WindowManager.LayoutParams.SOFT_INPUT_STATE_ALWAYS_HIDDEN);
		dialog.setContentView(R.layout.keypad_dialog);

		mExit = (Button) dialog.findViewById(R.id.action_exit);
		header = (TextView) dialog.findViewById(R.id.dialog_isi);
		mEditPin = (EditText) dialog.findViewById(R.id.input_pin);
		mKeyboardView = (KeyboardView) dialog.findViewById(R.id.keyboardview);
		mKeypadView = new KeypadView(activity, mKeyboardView, R.xml.keypad);

		header.setText(messageHeader);
		mExit.setOnClickListener(KeypadDialog.this);
		mKeypadView.setOnEnterKey(KeypadDialog.this);
		mEditPin.addTextChangedListener(this);
		mKeypadView.registerEditText(mEditPin);

		createTypeFont();

		dialog.setCancelable(false);
		dialog.show();
	}

	@Override
	public void onTextChanged(CharSequence s, int start, int before, int count) {
		value = s.toString();
	}

	@Override
	public void beforeTextChanged(CharSequence s, int start, int count,
			int after) {
	}

	@Override
	public void afterTextChanged(Editable s) {
	}

	@Override
	public void onClick(View v) {
		setCancel();
	}

	@Override
	public void runEnter() {
		if (getValue() != null && getValue().length() > 0) {
			executeEnter(getValue());
		}
	}

	private void createTypeFont() {
		FontUtil.applyFont(mExit, Font.AVANT_GARDE);
		FontUtil.applyFont(header, Font.AVANT_GARDE);
		FontUtil.applyFont(mEditPin, Font.AVANT_GARDE);
	}

	public void dialogDismiss() {
		dialog.dismiss();
	}

}
