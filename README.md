# Statamic: Relative HTML Cache Buster
If you need to bust other page caches when you update a certain piece
of content, then you've come to the right place.

## Installation
Download the repo and drop the relative\_cache\_buster folder into your
\_add-ons directory. There's a yaml file for you to tell buster what
to do.

Make sure that you have html caching enabled and your cache\_length is
set to _on last modified_ or _on cache update_.

## Configure
If the file your updating is a single file, simply use the page slug.
The example below will bust the homepage when the about page is updated.

```
"about-us":
 - "page.md"
```

You can also use a directory pattern. In this example, when a blog entry
is created or updated, the homepage and blog listing page will be
busted.

```
"blog/*":
 - "blog/page.md"
 - "page.md"
```

## Feedback & Contribute
Feedback? Ideas? Need support? Email us at
[support@thisbythem.com](mailto:support@thisbythem.com) or feel free to
fork and pull request your heart out. Happy hacking!
