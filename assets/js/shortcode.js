document.addEventListener('DOMContentLoaded', () => {
    const shortcodeContainers = document.querySelectorAll('.interactive-map-plugin');
    for (const shortcodeContainer of shortcodeContainers) {
        instantiateContainer(shortcodeContainer)
    }

})

function instantiateContainer(container) {
    console.log(container)
}