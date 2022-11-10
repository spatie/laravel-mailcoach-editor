export async function enter(element, transitionName) {
    element.classList.remove('hidden');

    element.classList.add(`${transitionName}-enter`);
    element.classList.add(`${transitionName}-enter-start`);

    await nextFrame();

    element.classList.remove(`${transitionName}-enter-start`);
    element.classList.add(`${transitionName}-enter-end`);

    await afterTransition(element);

    element.classList.remove(`${transitionName}-enter-end`);
    element.classList.remove(`${transitionName}-enter`);

    await nextFrame();
}

export async function leave(element, transitionName) {
    element.classList.add(`${transitionName}-leave`);
    element.classList.add(`${transitionName}-leave-start`);

    await nextFrame();

    element.classList.remove(`${transitionName}-leave-start`);
    element.classList.add(`${transitionName}-leave-end`);

    await afterTransition(element);

    element.classList.remove(`${transitionName}-leave-end`);
    element.classList.remove(`${transitionName}-leave`);

    element.classList.add('hidden');

    await nextFrame();
}

function afterTransition(element) {
    return new Promise(resolve => {
        const duration = Number(getComputedStyle(element).transitionDuration.replace('s', '')) * 1000;

        setTimeout(() => {
            resolve();
        }, duration);
    });
}

function nextFrame() {
    return new Promise(resolve => {
        requestAnimationFrame(() => {
            requestAnimationFrame(resolve);
        });
    });
}
