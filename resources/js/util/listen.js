export function listen(type, selector, callback) {
    document.addEventListener(type, event => {
        const target = event.target.closest(selector);

        if (!target) {
            return;
        }

        callback({ event, target });
    });
}
