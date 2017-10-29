import React, {Component} from 'react';
import axios from 'axios';

export default class Home extends Component {

    constructor(props) {
        super(props);

        this.state = {
            users: null
        };
    }

    componentDidMount() {
        axios.get('/api/user/all')
            .then(res => {
                this.setState({
                    users: res.data,
                });
            })
    }

    renderUsersList() {
        if (!this.state.users) {
            return null
        }

        return (
            <div className="row">
                <div className="container">
                    <div className="row">
                        <div className="col-md-4">
                            <strong>ID</strong>
                        </div>
                        <div className="col-md-4">
                            <strong>Username</strong>
                        </div>
                        <div className="col-md-4">
                            <strong>User balance</strong>
                        </div>
                    </div>
                    {
                        this.state.users.map((user, index) => {
                            return (
                                <div className="row" key={index}>
                                    <div className="col-md-4">{user.id}</div>
                                    <div className="col-md-4">{user.username}</div>
                                    <div className="col-md-4">{user.amount}</div>
                                </div>
                            );
                        })
                    }
                </div>
            </div>
        );
    }

    render() {
        return (
            <div className="container">
                <div className="row">
                    <div className="col-md-1">
                        <h1>USERS</h1>
                    </div>
                </div>
                {this.renderUsersList()}
            </div>
        );
    }
}