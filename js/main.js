function buildErrorBag(errors) {
    let errorBag = {};
    errors.forEach(error => {
        for (let field in error) {
            if (errorBag[field]) {
                errorBag[field].push(error[field]);
            } else {
                errorBag[field] = [error[field]];
            }
        }
    })

    return errorBag;
}