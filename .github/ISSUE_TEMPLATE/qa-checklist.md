---
name: QA Checklist
about: QA Checklist for final checks prior to launch.

---

# QA Checklist

This is to outline the necessary checks that need to take place on a website prior to launch.

**General Checks**
- [ ] `Discourage search engines from indexing this site` is not turned on
- [ ] Cookie Message exists
- [ ] Minified js & css files are being used
- [ ] All images are being pulled in via MKDO responsive functions
- [ ] Google Analytics installed _Client optional_
- [ ] All hard coded strings are wrapped in `esc_html_e( 'string', 'textdomain' )`
- [ ] Sitemap exists
- [ ] Forms are set to correct recipient
- [ ] Site meets PHPCS standards
- [ ] All plugins are up to date
- [ ] WP version is up to date
- [ ] [woo site] Test payments/orders
- [ ] No `var_dump`, `print_r` etc left in the code base
- [ ] No `console.log`'s left in the js code base
- [ ] Passes WCAG 2.0 AA
- [ ] HTML is semantic (uses HTML5 elements)

**Browser Checks**
- [ ] Functional in Chrome
- [ ] Functional in Safari
- [ ] Functional in Firefox
- [ ] Functional in Edge
- [ ] Functional in IE 11 (Check relevant version if you are working on an NHS site)
- [ ] Functional in Opera

**Mobile Checks [responsive]**
- [ ] iPhone SE/5 Portrait
- [ ] iPhone SE/5 Landscape
- [ ] iPhone 6 Portrait
- [ ] iPhone 6 Landscape
- [ ] iPhone 8 Plus Portrait
- [ ] iPhone 8 Plus Landscape
- [ ] iPad Mini Portrait
- [ ] iPad Mini Landscape
- [ ] iPad Portrait
- [ ] iPad Landscape
- [ ] iPad Pro Portrait
- [ ] iPad Pro Landscape

**Mobile Checks [os check]**
- [ ] Android (latest 3 versions)
- [ ] Android Tablets
