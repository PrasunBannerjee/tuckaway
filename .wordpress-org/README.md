# WordPress.org directory assets

Nothing in this folder ships inside the plugin zip. These files live in
the `assets/` directory of the plugin's **SVN** repository on
WordPress.org, which is separate from the plugin's own code, and are
what the directory listing page renders and previews from.

## Required — done

`assets/icon-256x256.png`, `assets/icon-128x128.png`,
`assets/banner-772x250.png`, and `assets/banner-1544x500.png` in this
folder are the real, final files. Commit them as-is to
`https://plugins.svn.wordpress.org/tuckaway/assets/` when the
plugin is submitted.

| File | Size | Source |
| --- | --- | --- |
| `assets/icon-256x256.png` | 256 × 256 | Drawn by `bin/draw-brand-assets.py`: the stacked-T mark, ink on a transparent ground. |
| `assets/icon-128x128.png` | 128 × 128 | Same drawing, rendered at half size. |
| `assets/banner-772x250.png` | 772 × 250 | Drawn by the same script: paper mark on ink, with the Flare strike running in from the left edge. |
| `assets/banner-1544x500.png` | 1544 × 500 | Same drawing, rendered at 2x. |

To change the mark, edit the script and run it again rather than
editing the PNGs by hand, so all four stay in step:

```bash
python3 -m pip install pillow
python3 bin/draw-brand-assets.py .wordpress-org/assets
```

**No type in the artwork.** The banners carry no text, because the
directory renders the plugin name and author over the calm left third
of the banner. A title baked into the pixels would show twice.

**One judgment call on the icon.** WordPress.org doesn't support a
separate icon for dark mode, only one file, so a choice had to be made
between the ink-on-white mark and the paper-on-ink one. Went with
ink-on-white — that's the version built for light grounds, and the
Plugins screen and search results are white or light grey in the
overwhelming majority of real installs, dark admin color schemes
included (only the directory's own dark mode, which is rarer, is the
edge case this doesn't cover). **Confirmed:** the icon ships as the
ink-on-white mark.

## Recommended

| File | Notes |
| --- | --- |
| `assets/screenshot-1.png` | Front end, collapsed: the "Read More" link with the rest of the content hidden. |
| `assets/screenshot-2.png` | Front end, expanded: "Read Less" at the end of the revealed text. |
| `assets/screenshot-3.png` | The `[readmore]` marker on its own line in the block editor. |

**Done.** Each file matches, in order, a caption under
`== Screenshots ==` in `readme.txt`. The directory takes the captions
from there, so if you add, remove, or reorder an image, update that
section to match; a caption with no image shows up as a broken gallery.

All three were taken at 1280px wide (saved at 1.25x, so 1600px) from
a stock WordPress install running Twenty Twenty-Five, with the plugin
loaded from this repository. The demo page is a made-up community
garden, so no real site or brand appears in them.

## Live Preview blueprint

`blueprints/blueprint.json` in this folder is committed to SVN as
`assets/blueprints/blueprint.json`. It boots a WordPress Playground
instance, installs and activates the plugin from the directory, creates
a demo page that uses the marker, and sets that page as the front page,
so the preview opens on a working example rather than an empty site.

Two things are needed for the public **Preview** button to appear:

1. A valid `blueprint.json` at that path. Until then there is no button.
2. A committer must set the plugin preview to "public" from the
   plugin's **Advanced** view. Before that, only committers see it, as a
   **Test Preview** button.

The blueprint installs the plugin by its `tuckaway` slug from
wordpress.org, so it only works once the plugin is approved and live.

## Constraints

- Banners: JPG or PNG. Icons: PNG, JPG, GIF, or SVG with a PNG
  fallback. Screenshots: PNG or JPG. No WebP or AVIF anywhere.
- All filenames must be lowercase.
- Size ceilings: 4 MB per banner, 1 MB per icon, 10 MB per screenshot.
  Staying well under those is better; the directory serves them
  uncompressed.
- Avoid putting small text in the banner. It is scaled down heavily on
  mobile and becomes unreadable.
- Do not use the WordPress logo, the Elementor logo, or any other
  trademark you do not own. This is one of the more common reasons a
  submission gets bounced.
