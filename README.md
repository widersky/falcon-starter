<p align="center">
<img src="wp-content/themes/falcon/framework/logo.png" />
</p>

<h1 align="center">New generation starter theme for WordPress</h1>

<p align="center">
<img src="https://img.shields.io/github/commit-activity/m/widersky/falcon-starter" />
<img src="https://img.shields.io/github/last-commit/widersky/falcon-starter" />
<img src="https://img.shields.io/github/issues/widersky/falcon-starter" />
<img src="https://img.shields.io/github/license/widersky/falcon-starter" />
</p>

## 🤔 What's the idea?

WordPress has its advantages and disadvantages. It is a blogging system that turns out to be pretty good for many other uses as well. 
Business cards, business sites, portfolios, and even stores - it's estimated that about 60% of the world's web uses WordPress. 
However, if you're not using it as a blogging platform, certain features are completely unnecessary. 
Falcon allows you to easily disable them, bringing more order and tidiness to your code. But that's not all! 
Falcon is designed to help you achieve your goals faster and easier than bare wordpress. 
Designed to use ACF Pro based blocks, it is a great foundation for almost any website possible to create with WordPress. 
I write about why I abandoned traditional Gutenberg blocks in [Wiki](https://github.com/widersky/falcon-starter/wiki).
Besides, not everyone needs to use blown up just out of the blue professional looking tools for their job. 
Webpack has been on the market for a good few years now and in many ways it is outdated. 
However, it is certainly slow. Much slower than ESBuild. 
When working with Falcon, you won't even notice that something is running in the background and processing your files.
To sum up, Falcon will provide you as a developer:
- Faster work
- Fewer things to do at the beginning of your work
- Simplicity and readability
- Disabling unnecessary bits and pieces that WP uses by default

> I can't guarantee that everything will work perfectly - I tested Falcon under fairly limited conditions. However, if you have any needs, or something doesn't work as it should for you - go ahead and [let me know](https://github.com/widersky/falcon-starter/issues)!

So...

## 🦅 What's inside?

### ESBuild as a bundler

[ESBuild is blazing fast](https://esbuild.github.io). I don't think I need to add anything more. 
How to work with JS and CSS code in Falcon, I write in the [Wiki].(https://github.com/widersky/falcon-starter/wiki) - there is full documentation there.

### Pure JS

You can use just pure modern JS and nothing else. Up to ES2020 standard. You can put your global scripts in `src/js/main.js` file.

### Tailwind CSS

Beloved by developers from whole world [Tailwind CSS](https://tailwindcss.com) is here! And you don't need to make anything -
it just works! Feel free to match it to your needs by editing `tailwind.config.js` file!

### Out-of-box ACF/Pro support

To use some features (like repeaters or options pages) you'll need to use ACF in Pro version. 
Falcon strongly uses ACF Pro features - for example to make Gutenberg blocks easier.
I write about why I abandoned traditional Gutenberg blocks in [Wiki](https://github.com/widersky/falcon-starter/wiki).

### Completely modularised structure

Gutenberg is a WP standard, you know it and I know it too. 
Falcon uses a specific directory structure, which is important for everything to work as it should. 
I have tried to make it readable and convenient. 
Unfortunately ESBuild has its limitations and JS and CSS files can't be found in block directories - as soon as it becomes possible, I'll probably change this scheme. 
Dividing it into blocks makes the page load only the code that is really relevant and nothing else. 
Also, with TailwindCSS you don't use redundant CSS and reduce a lot of the problems that can come from nesting styles!

## Micro Framework

Falcon isn't just a theme - it's a whole framework helping you make things easier and better! There's
a `framework` folder with some useful classes described in [Wiki](https://github.com/widersky/falcon-starter/wiki).

# 🚀 How to start?

Just copy falcon theme folder into your wordpress instalation, rename to your needs and run this command using terminal:

```bash
npm i
```

Once installed, create an .env file in the theme directory according to the following scheme by replacing the natural url with your local address where the website runs:

```
URL=http://your-url-here.test:1234
```

Then, just run:

```bash
npm start
```

Browser with opened site should be opened now. Any change will result in a page reload. 
Remember to use the `npm run build` command at the end of your work - it will give you optimized and minified code!
\
\
Happy Coding!

# 🥸 Known issues

0 at the moment.
