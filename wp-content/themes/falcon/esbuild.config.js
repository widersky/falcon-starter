require("dotenv").config();
const path = require("path");
const glob = require("glob");
const browserSync = require("browser-sync").create();

const esbuild = require("esbuild");
const stylePlugin = require("esbuild-style-plugin");

// Badges
const badge = {
    falcon: "\x1b[33m[Falcon]\x1b[0m",
    error: "\x1b[31m[ERR]\x1b[0m"
}

// Project setup
const project = {
    url: process.env.URL,
    isDevMode: process.env.NODE_ENV === "dev",
    ignore: [ "*.svg", "*.woff", "*.css", "*.jpg", "*.webp", "*.png", "node_modules/*" ],
    paths: {
        base: path.resolve(__dirname),
        src: path.resolve(__dirname, "src"),
        dist: path.resolve(__dirname, "dist"),
    },
};

console.log(`${badge.falcon} Version ${process.env.npm_package_version}
${badge.falcon} Note that dev build is not optimized for production. Run \x1b[33mnpm run build\x1b[0m to minify and compress assets.\n`);

// Construct entries array
console.log(`${badge.falcon} Collecting blocks data...`);
const entryPoints = [
    `${project.paths.src}/js/main.js`,
    `${project.paths.src}/css/main.css`,
];
const entries = glob
    .sync(`${project.paths.base}/partials/blocks/**/*.json`)
    .reduce((_, filePath) => {
        const pureJSON = JSON.stringify(require(filePath));
        const data = JSON.parse(pureJSON);
        const blockSlug = path.basename(filePath).split(".")[0];
        
        if (data.blockEnabled) {
            if (data.scripts) entryPoints.push(`${project.paths.src}/js/block-${blockSlug}.js`);
            if (data.styles) entryPoints.push(`${project.paths.src}/css/block-${blockSlug}.css`);

            console.log(`${badge.falcon} Block \x1b[32m${blockSlug}\x1b[0m added to bundle.`);
        } else {
            console.log(`${badge.falcon} Block \x1b[33m${blockSlug}\x1b[0m skipped.`);
        }

        return entryPoints;
    }, {});
console.log(`${badge.falcon} Blocks data collected.\n`);

const build = async () => {
    console.log(`${badge.falcon} Building...`);
    
    try {
        const start = Date.now();
        
        await esbuild.build({
            entryPoints: entries,
            outdir: project.paths.dist,
            minify: !project.isDevMode,
            sourcemap: true,
            bundle: true,
            target: ["es2020"],
            plugins: [
                stylePlugin({
                    postcssConfigFile: true,
                    postcss: [
                        require('tailwindcss/nesting'),
                        require('tailwindcss'),
                        require('autoprefixer'),
                        require('postcss-preset-env')({
                            browsers: 'last 2 versions',
                        }),
                    ]
                })
            ],
            external: project.ignore
        });
        
        const finish = Date.now();
        
        console.log(`${badge.falcon} Built in ${finish - start}ms`);
    } catch (error) {
        console.log(`${error}`);
        console.log(error);
    }
}

if (project.isDevMode) {    
    build();
    
    browserSync.init({
        port: 3000,
        ui: false,
        proxy: project.url,
        logLevel: "warn"
    });
    
    browserSync.watch(["**/*.php", "src/**/*", "framework/**/*"], (event, file) => {
        if (event === "change") {
            console.log(`${badge.falcon} File \x1b[33m${file}\x1b[0m has changed.`);
            
            build();
            browserSync.reload();
        }
    })
} else {
    build();
}
