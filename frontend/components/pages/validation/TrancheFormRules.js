export const rules = {
    recipient: {
        presence: true,
        length: {
            minimum: 1,
            message: "field can't be empty",
        },
    },
    amount: {
        presence: true,
        format: {
            pattern: "^\\d+(\\.\\d{1,2})?$",
            message: "incorrect",
        },
    },
};