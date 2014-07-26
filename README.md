# Statamic: Relative HTML Cache Buster
Statamic's HTML caching makes your website load fast. Lightning speed
fast. What's faster than loading a static HTML file? If you're using
aggressive caching (on last modified) Statamic handles busting the
detail page just fine, but chances are you're pulling in that content
into other pages on your site.

For example: Say your homepage features the last few blog posts of your
site, and you also have a blog listing page with titles and excerpts.
Lo and behold, you find a typo in the title, update it in the admin. The
blog post detail is updated no problem, but that typo is still on the
homepage and blog index page. Oh no! SSH'n in to clear the cache is
gonna get old real quick.

And don't even get me started with clients.

## Buster to the Rescue
Give buster the URL (or pattern) of the updated file, and a list of
pages to bust and fret no more! Bustin' that cache like the wild west.

## Installation
Download the repo and drop the relative\_cache\_buster folder into your
\_add-ons directory. There's a yaml file for you to tell buster what
to do.

## Configure
If the file updated is a single file, simply use the page slug. The
example below will bust the homepage when the about page is updated.

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
Feedback? Ideas? Need support? Email us at support@thisbythem.com. Or
feel free the fork and pull request. Happy hacking!
