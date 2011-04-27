Socializr
===============
Socializr is a WordPress plugin which allow you to link your blog with a Facebook page and a Twitter account.

features
------------------
* Adding a [Facebook Like Button](http://developers.facebook.com/docs/reference/plugins/like) before post content.
* Adding a [Tweet Button](http://twitter.com/about/resources/tweetbutton) before post content.
* Adding a widget [Facebook Like Box](http://developers.facebook.com/docs/reference/plugins/like-box).
* Adding a widget [Twitter](http://twitter.com/about/resources/widgets).
* Publishing automatically all new post on your Facebook wall and your Twitter timeline.
* Adding a new page in WordPress administration to share link (with comment) on your Facebook wall and your Twitter timeline.

setup
------------------

1. Download plugin
        cd wp-content/plugin
        git clone git://github.com/blat/wp-socializr-plugin.git
        mv wp-socializr-plugin socializr

2. Initialize configuration
        cd socializr
        cp config.php-dist config.php

3. Go to [facebook.com](http://www.facebook.com/developers/createapp.php) and create a new application. Be careful when you fill **site url**. A wrong value can block the authentification.

4. Update `config.php` to copy **Application ID** as **CLIENT_ID** and **Application Secret** as **CLIENT_SECRET**.

5. Go to [twitter.com](http://twitter.com/apps/new) and create a new application. Choose _browser_ as **Application Type** and _Read & Write_ as **Default Access type**.

6. Update `config.php` to copy **Consumer key** as **CONSUMER_KEY** and **Cosumer secret** as **CONSUMER_SECRET**.

7. Go to [plugin manager](http://www.yoursite.com/wp-admin/plugins.php) and activate the new plugin.

8. Go to [Socializr settings page](http://www.yoursite.com/wp-admin/options-general.php?page=socializr) and link your blog with your Facebook page and your Twitter account.

settings
------------------

![General settings](http://pix.toile-libre.org/upload/original/1288810011.png)

![Tweet Button settings](http://pix.toile-libre.org/upload/original/1288810087.png)

![Facebook Like Button settings](http://pix.toile-libre.org/upload/original/1288810056.png)

![Twitter Widget settings](http://pix.toile-libre.org/upload/original/1288810196.png) ![Facebook Like Box settings](http://pix.toile-libre.org/upload/original/1288810145.png)

mit licence
------------------
Copyright (c) 2010 Mickael BLATIERE

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

