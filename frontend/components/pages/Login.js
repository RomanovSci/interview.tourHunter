import React, {Component} from 'react';
import {browserHistory} from 'react-router';
import axios from 'axios';
import AuthHelper from '../helpers/AuthHelper';

export default class Login extends Component {

    constructor(props) {
        super(props);

        this.state = {
            username: '',

            checked: false,
            authorized: false,
        }
    }

    componentDidMount() {

        AuthHelper.checkUser(res => {

            if (res.data.hasOwnProperty('authorized')) {
                this.setState({
                    authorized: res.data.authorized,
                    checked: true,
                });
            }
        });
    }

    /**
     * Handle submit action
     * @param e
     * @return void
     */
    handleSubmit(e) {
        e.preventDefault();

        axios.post('/api/auth/login',{
            User: {
                username: this.state.username,
            },
        })
        .then(({data}) => {

            if (data.hasOwnProperty('success') && data.success) {
                localStorage.setItem('token', data.token);
                browserHistory.push('/personal');
            }
        });
    }

    /**
     * Handle input change
     * @param field
     * @param e
     * @return void
     */
    handleInputChange(field, e) {
        this.setState({
            [field] : e.target.value,
        });
    }

    /**
     * Render login template
     * @returns {XML}
     */
    render() {
        /** Waiting for user state checking **/
        if (!this.state.checked) {
            return <p>Loading...</p>
        }

        /** Redirect to main page for authorized user **/
        if (this.state.authorized) {
            browserHistory.push('/personal');
            return null;
        }

        /** Render login page **/
        return (
            <div className="container">
                <div className="row">
                    <form className="form" onSubmit={this.handleSubmit.bind(this)}>
                        <input
                            className="form-control"
                            name="User[username]"
                            type="text"
                            placeholder="Username"
                            value={this.state.username}
                            onChange={this.handleInputChange.bind(this, 'username')}
                        />
                        <input
                            className="btn btn-success"
                            type="submit"
                            value="login"
                        />
                    </form>
                </div>
            </div>
        );
    }
}