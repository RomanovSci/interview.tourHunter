import axios from 'axios';

export default class AuthHelper {

    /**
     * Check user state
     *
     * @returns {AxiosPromise}
     */
    static checkUser(callback) {
        axios
            .get(`/api/auth/check?access_token=${localStorage.getItem('token')}`)
            .then(callback);
    }
};