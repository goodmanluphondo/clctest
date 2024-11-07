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

const rules = {
    firstName: {
        required: true,
    },
    lastName: {
        required: true,
    },
    username: {
        required: true,
    },
    password: {
        required: true,
        minLength: 8,
        maxLength: 15,
        upperCase: true,
        specialChar: true,
    },
    codingLanguage: {
        isNumber: true,
        required: true,
    }
}