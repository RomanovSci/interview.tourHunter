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
                <br/><br/>
                <div className="row">
                    <form className="com-md-3" onSubmit={this.handleSubmit.bind(this)}>
                        <div className="form-group">
                            <input
                                id="username"
                                className="form-control"
                                placeholder="username"
                                value={this.state.username}
                                onChange={this.handleInputChange.bind(this, 'username')}
                            />
                        </div>
                        <div className="form-group">
                            <input
                                className="btn btn-success"
                                type="submit"
                                value="login"
                            />
                        </div>
                    </form>
                </div>
            </div>
        );
    }
}