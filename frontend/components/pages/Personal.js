import React, {Component} from 'react';
import AuthHelper from '../helpers/AuthHelper';
import {browserHistory} from 'react-router';
import TrancheForm from "./forms/TrancheForm";

export default class Personal extends Component {

    constructor(props) {
        super(props);

        this.state = {
            username: '',
            transactions: [],

            checked: false,
            authorized: false,
        };
    }

    componentDidMount() {

        AuthHelper.checkUser(({data}) => {

            if (data.hasOwnProperty('authorized')) {
                this.setState({
                    checked: true,
                    authorized: data.authorized,
                    username: data.username,
                    transactions: data.transactions,
                });
            }
        });
    }

    logout() {
        localStorage.setItem('token', null);
        browserHistory.push('/login');
    }

    render() {

        if (!this.state.checked) {
            return <p>Loading...</p>
        }

        if (!this.state.authorized) {
            browserHistory.push('login');
            return null;
        }

        return (
            <div>
                <div className="user-info">
                    <h1>{this.state.username}</h1>
                    <button className="btn btn-danger" onClick={this.logout.bind(this)}>Logout</button>
                </div>
                <div className="container">
                    <div className="row">
                        <div className="col-md-6">
                            <h2>Transfer funds</h2>
                            <TrancheForm username={this.state.username} />
                        </div>
                        <div className="col-md-6">
                            <h2>Transactions</h2>
                            <div className="container">
                                <div className="row">
                                    <div className="col-md-3">
                                        <strong>From</strong>
                                    </div>
                                    <div className="col-md-3">
                                        <strong>To</strong>
                                    </div>
                                    <div className="col-md-3">
                                        <strong>Amount</strong>
                                    </div>
                                    <div className="col-md-3">
                                        <strong>Date</strong>
                                    </div>
                                </div>
                                {
                                    this.state.transactions.map((transaction, index) => {
                                        return (
                                            <div className="row" key={index}>
                                                <div className="col-md-3">
                                                    {transaction.sender_username}
                                                </div>
                                                <div className="col-md-3">
                                                    {transaction.recipient_username}
                                                </div>
                                                <div className="col-md-3">
                                                    {transaction.amount}
                                                </div>
                                                <div className="col-md-3">
                                                    {transaction.created_at}
                                                </div>
                                            </div>
                                        );
                                    })
                                }
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}