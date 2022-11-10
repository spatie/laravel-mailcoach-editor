export default ({ command }) => ({
    base: command === 'serve' ? '' : '/build/',
    publicDir: 'fake_dir_so_nothing_gets_copied',
    build: {
        manifest: true,
        outDir: 'resources/dist',
        rollupOptions: {
            input: 'resources/js/editor.js',
        },
    },
});
