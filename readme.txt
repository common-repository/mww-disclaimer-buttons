=== MWW Disclaimer Buttons ===
Contributors: mossifer
Donate link: http://www.mosswebworks.com/donate/
Tags: disclaimers, disclosures, affiliate links, sponsored posts, PR samples
Requires at least: 4.2
Tested up to: 6.6.2
Stable tag: trunk
Requires PHP: 7.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

The FTC requires that you put disclosures at the top of your post if you were compensated in any way (affiliate links, free products, or payment). This plugin insert those disclaimers automatically with small customizable buttons.

== Description ==

For bloggers/content creators that accept free products or compensation for reviews, or use affiliate links, the FTC requires that you put disclosures at the top of any post or page.

This plugin creates an options box in the POST or PAGE editor for you to add each of these buttons to your post without having to include it in post text. 

[Affiliate Links] - Blogger makes money when someone clicks on link and purchases product from 3rd party vendor.

[PR Sample] - Free product was received by blogger in exchange for a review and/or post.

[Sponsored] - Blogger was paid directly for the post/page.

The disclaimer buttons appear below the title and above the text on a single post or page--they do not appear on excerpts nor your RSS feed. 

== Short Description ==
Generates disclaimer buttons for bloggers that receive any compensation for reviews, including affiliate links.

== Installation ==

1. Install MWW Disclaimers Plugin and activate.

2. Create a disclosures page. For FTC tips on writing disclosures, visit: https://www.ftc.gov/tips-advice/business-center/guidance/ftcs-endorsement-guides-what-people-are-asking

3. Go to Settings | Disclaimer Buttons and set the disclaimers/disclosure page you just created. Set the colors and padding of your buttons.

4. While creating or editing a post/page, choose the buttons you would like to display. The buttons checkboxes are in the right-hand column, usually near the TAGS box.

5. Check your single post or page and see the buttons at the top. If you are familiar with CSS, use CUSTOM CSS in WordPress or your theme settings to override the plugin’s default stylesheet. Check the buttons.css stylesheet in this directory to learn the codes.

== Frequently Asked Questions ==

= Can I modify what the buttons say? =

Not at this point, no. We have included the 3 most frequently used disclaimers: Affiliate Links, PR Sample, and Sponsored.

= Can I modify how the buttons look? =

Yes. We have added an option to update the button color, text color, and padding in the settings. If you want to modify any other style, just update buttons.css in the plugin’s directory.

= Can I put the buttons somewhere else, like at the bottom of the post? =

No. FTC regulations state that they must be at the top of the post. The best place for the buttons are at the top of the post text. I didn’t have them attached to the post meta (date/author), because some themes allow you to hide those elements.

= Do I have to create a full disclaimer page? =

Yes. The U.S. Federal Trade Commission requires that you link to a page that fully describes your various relationships and compensation for posts. For more information visit: visit: https://www.ftc.gov/tips-advice/business-center/guidance/ftcs-endorsement-guides-what-people-are-asking

== Screenshots ==
1. Plugin settings: set your disclaimers page.
2. While creating or editing a post, check the buttons you want to appear.
3. Buttons will appear at the top of post text in Single Post view only.

== Changelog ==

= 3.41 =
Turns off non-critical warning messages.

= 3.4 =
Set it so buttons don't show up on home page post blocks.

= 3.3 =
Fixed bug where buttons didn't show up on pages.

= 3.2 =
Security patch

= 3.1 =
Changed so that button text does not show up in excerpts, only on top of the single post article itself. Tested to 6.3

= 3.0.2 =
Fixed php code tag. Tested to 6.0.1

= 3.0.1 =
Fixed default button colors. Tested to 6.0

= 3.0 =
Added functionality to choose button colors, text colors, and padding.

= 2.0.3 = 
Fixed undefined variable error

= 2.0.2 = 
Changed buttons.css so settings can be overrided by custom CSS

= 2.0.1 = 
Bug fix - div code showing on page that has no buttons

= 2.0 =
* Page editor now contains Disclaimers box to add buttons to a page
* Single page view displays disclaimer buttons, if set.

= 1.0 =
* Initial plugin release

== Upgrade Notice ==


== Markdown ==
1. Admin Page for entering disclaimer URL
2. Settings box on post page
3. Appends buttons to the_content() (post text) on single post or page only.
