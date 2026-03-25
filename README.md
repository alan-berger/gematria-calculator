# Gematria Calculator

A PHP-based Gematria calculator using the following encoding:

**a=6, b=12, c=18, d=24, e=30, f=36** — each letter of the alphabet is assigned a value in multiples of 6, up to z=156.

Originally built in the early 2000s out of curiosity after discovering that _computer_ = 666 using this encoding as a teenager. Statistically, given the distribution of letter frequencies and word lengths, any given value will match hundreds of words in a typical dictionary — the results are a curiosity rather than meaningful numerology.

---

## Files

| File | Description |
|---|---|
| `beastcalc.php` | Single word/phrase calculator — input form |
| `beastform.php` | Single word/phrase calculator — results |
| `beastcalcbulk.php` | Bulk calculator — upload form |
| `beastformbulk.php` | Bulk calculator — results |

---

## Usage

### Single Calculator
Enter a word or phrase into `beastcalc.php`. Each letter is assigned its value and the total is displayed. Maximum input length is 128 characters. Case-insensitive.

### Bulk Calculator
`beastcalcbulk.php` accepts a `.txt` file (max 2MB) with one word per line, and a filter value between 6 and 9996 (multiples of 6 only). It returns every word in the file whose Gematria value matches the filter, along with a match count.

A sample dictionary file can be found at many open word list repositories, such as [dwyl/english-words](https://github.com/dwyl/english-words).

---

## Requirements

- PHP 8.0 or later (the bulk calculator uses `match` expressions introduced in PHP 8.0)
- A web server with PHP configured to handle file uploads (`file_uploads = On` in `php.ini`)

---

## Deployment

Drop all four files into a directory on your web server. No database or additional dependencies are required.

These files are intentionally self-contained with no external includes or stylesheets, so they will work out of the box but will look unstyled. To integrate into an existing site, add your own stylesheet link and any shared includes (header, navigation, footer) to each file as needed.

If your calculator files live in a subdirectory, use root-relative paths (e.g. `/menu.php`) or `__DIR__`-relative includes (e.g. `include(__DIR__ . '/../menu.php')`) rather than bare relative paths, to ensure includes resolve correctly regardless of the calling URL.

---

## Security Notes

- All user input is validated server-side and HTML-escaped before output
- The bulk upload validates the PHP error code, checks `is_uploaded_file()`, enforces the 2MB size limit server-side, and restricts uploads to `.txt` files only
- The filter value is validated as an integer, a multiple of 6, and within the permitted range server-side, regardless of what the form submits

---

## License

MIT
