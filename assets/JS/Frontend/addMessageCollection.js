const prototypeInput = document.querySelector('.js-collection-messages');
if (prototypeInput) {
    addFormToCollection(prototypeInput);
}




function addFormToCollection(collectionHolder) {
    // const collectionHolder = document.querySelector('.' + e.currentTarget.dataset.collectionHolderClass);

    let index = 0;
    collectionHolder.innerHTML = collectionHolder
        .dataset
        .prototype
        .replace(
            /__name__/g,
            index
        );

    // collectionHolder.appendChild(item);

    index++;
};