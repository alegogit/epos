package co.zakuna.pos.widget;

import android.content.Context;
import android.graphics.Typeface;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import lombok.*;

import java.lang.ref.SoftReference;
import java.util.HashMap;

public class FontUtil {
	public static enum Font {
		AVANT_GARDE("ITCAvantGardeStd-Md.otf", "ITCAvantGardeStd-Bold.otf");

		@Getter
		private final String regularName;
		@Getter
		private final String boldName;

		private Font(String reg, String bold) {
			regularName = reg;
			boldName = bold;
		}
	};

	private static final HashMap<Font, SoftReference<FontFamily>> fonts = new HashMap<Font, SoftReference<FontFamily>>();

	public static void applyFont(View view, Font fontName) {
		SoftReference<FontFamily> fontRef = fonts.get(fontName);
		FontFamily font = fontRef == null ? null : fontRef.get();

		if (font == null) {
			font = new FontFamily(view.getContext(), fontName);
			fonts.put(fontName, new SoftReference<FontFamily>(font));
		}

		applyFont(view, font);
	}

	public static void applyFont(View view, FontFamily font) {
		if (view != null) {
			if (view instanceof TextView) {
				applyFont((TextView) view, font);
			} else if (view instanceof ViewGroup) {
				applyFont((ViewGroup) view, font);
			}
		}
	}

	public static void applyFont(TextView view, FontFamily font) {
		Typeface tf = view.getTypeface();
		if (tf == null)
			view.setTypeface(font.getRegular());
		else if (tf.isBold())
			view.setTypeface(font.getBold());
		else
			view.setTypeface(font.getRegular());
	}

	public static void applyFont(ViewGroup view, FontFamily font) {
		for (int i = 0; i < view.getChildCount(); ++i) {
			applyFont(view.getChildAt(i), font);
		}
	}

	private static class FontFamily {
		@Getter
		private final Typeface regular;
		@Getter
		private final Typeface bold;

		public FontFamily(Context context, Font font) {
			regular = getTypeface(context, font.getRegularName());
			bold = getTypeface(context, font.getBoldName());
		}

		private static Typeface getTypeface(Context context, String name) {
			return Typeface.createFromAsset(context.getAssets(),
					String.format("fonts/%s", name));
		}
	}
}
