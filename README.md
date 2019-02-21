![bluetube](https://github.com/Mehrunes-Dagon/bluetube/blob/master/assets/images/logo.png "BlueTube")

### A video app like YouTube but only for sad videos

- OO PHP
- Jquery
- Bootstrap

### php.ini modifications

- `max_execution_time=3000`
- `max_filesize=1024M`

#### Must include [ffmpeg and ffprobe](https://www.ffmpeg.org/download.html) in `assets/ffmpeg` for Widows, Mac, or Linux accordingly

### TODO:

- replies comments hide button
- make delete video button
- make all errors in span with class
- processing, comments, need Sanitizer
- make requires are only where necessary
- add custom profile picture feature
- make comment reply nesting limited to 1
- add custom banner feature
- make User class properties private, only functions public
- foreign key constraints on privacy and category db attrs
