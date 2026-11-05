#!/usr/bin/env python3
"""Draws the stacked-T Tuckaway mark into the WordPress.org icon and banner PNGs.

Development only; never ships in the plugin zip. Needs Pillow:

    python3 -m pip install pillow
    python3 bin/draw-brand-assets.py .wordpress-org/assets

Overwrites icon-256x256.png, icon-128x128.png, banner-772x250.png and
banner-1544x500.png in the given folder. The geometry and colours are
the ones described in .wordpress-org/design.md.
"""
import sys
from PIL import Image, ImageDraw

INK = (28, 28, 30)
PAPER = (241, 239, 236)
FLARE = (226, 62, 30)
SS = 4  # supersampling factor for smooth corners

def render(path, size, scale, bg, bars, strike, bar_h, fg, dim):
    W, H = size
    im = Image.new('RGBA', (W * SS, H * SS), bg)
    d = ImageDraw.Draw(im)
    k = scale * SS
    r = bar_h * 0.25 * k
    for x0, x1, y, faded in bars:
        d.rounded_rectangle([x0 * k, y * k, x1 * k, (y + bar_h) * k], radius=r, fill=dim if faded else fg)
    sx0, sx1, sy, sh = strike
    d.rounded_rectangle([sx0 * k, sy * k, sx1 * k, (sy + sh) * k], radius=sh / 2 * k, fill=FLARE + (255,))
    im.resize((W, H), Image.LANCZOS).save(path, optimize=True)

def t_bars(left, right, stem_ratio, rows, below):
    stem = (right - left) * stem_ratio
    cx = (left + right) / 2
    out = [(left, right, rows[0], False)]
    for i, y in enumerate(rows[1:], start=1):
        out.append((cx - stem / 2, cx + stem / 2, y, i >= below))
    return out

out = sys.argv[1]
# Icon: same rows, bar height, and fold line as the S mark it replaces,
# designed on the 256 grid and rendered again at half size for 128.
icon_rows = [62, 89, 116, 151, 178]
icon = dict(bars=t_bars(76, 180, 0.27, icon_rows, 3), strike=(60, 196, 139, 5), bar_h=16,
            bg=(255, 255, 255, 0), fg=INK + (255,), dim=INK + (116,))
render(f'{out}/icon-256x256.png', (256, 256), 1, **icon)
render(f'{out}/icon-128x128.png', (128, 128), 0.5, **icon)
# Banner: ink ground, paper bars, the fold line running in from the left
# edge as before. Designed on the 772 grid, rendered again at 2x.
banner_rows = [47, 79, 110, 151, 183]
banner = dict(bars=t_bars(562, 684, 0.27, banner_rows, 3), strike=(48, 703, 137, 6), bar_h=20,
              bg=INK + (255,), fg=PAPER + (255,), dim=(125, 124, 124, 255))
render(f'{out}/banner-772x250.png', (772, 250), 1, **banner)
render(f'{out}/banner-1544x500.png', (1544, 500), 2, **banner)
