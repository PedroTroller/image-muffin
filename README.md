This script will return the content of the image directly.

## Usage

```bash
  vendor/bin/muffinizer [options]
```

## Options
      --landscape        Will generate a landscape.
      --portrait         Will generate a portrait.
      --width[=WIDTH]    The desired width of the image.
      --height[=HEIGHT]  The desired height of the image.
      --bmp              Will generate a .bmp image.
      --gif              Will generate a .gif image.
      --jpeg             Will generate a .jpeg image.
      --jpg              Will generate a .jpg image (default).
      --png              Will generate a .png image.
      --wbmp             Will generate a .wbmp image.
      --webp             Will generate a .webp image.
      --xbm              Will generate a .xbm image.
      --content          Will return the content of the resulting image (default).
      --base64           Will return the base64 of the resulting image.
  -h, --help             Display this help message
  -q, --quiet            Do not output any message
  -V, --version          Display this application version
      --ansi             Force ANSI output
      --no-ansi          Disable ANSI output
  -n, --no-interaction   Do not ask any interactive question
  -v|vv|vvv, --verbose   Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug

## Examples

### Generate a landscape image

```bash
  vendor/bin/muffinizer --landscape
```

#### Generate a landscape image with a specific size

```bash
  vendor/bin/muffinizer --landscape --width 300
```

```bash
  vendor/bin/muffinizer --landscape --height 300
```

### Generate a portrait image

```bash
  vendor/bin/muffinizer --portrait
```

#### Generate a portrait image with a specific size

```bash
  vendor/bin/muffinizer --portrait --width 300
```

```bash
  vendor/bin/muffinizer --portrait --height 300
```

### Generate an image with width and height

```bash
  vendor/bin/muffinizer --portrait --width 300 --height 300
```
