import React, {Component} from 'react';
import validate from 'validate.js';
import {rules} from '../validation/TrancheFormRules';
import {NotificationContainer, NotificationManager} from 'react-notifications';
import axios from 'axios';

export default class TrancheForm extends Component {

    constructor(props) {
        super(props);

        this.state = {
            recipient: '',
            amount: '',
        };
    }

    handleFieldChange(field, e) {
        this.setState({
            [field]: e.target.value,
        });
    }

    handleSubmit(e) {
        e.preventDefault();

        if (!this.validate()) {
           return;
        }

        axios({
            url: '/api/balance/tranche',
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            },
            data: {
                recipient: this.state.recipient,
                amount:    this.state.amount,
            }
        })
            .then(({data}) => {

                if (data.hasOwnProperty('success') && data.success) {
                    location.reload();
                    return;
                }

                NotificationManager.error(data.error);
            })
            .catch(errors => {

                if (errors.response.data.message) {
                    NotificationManager.error(errors.response.data.message);
                }
            });
    }

    validate() {
        let errors = validate(this.state, rules);

        if (!errors) {
            return true;
        }

        /** Show first error */
        NotificationManager.error(
            errors[Object.keys(errors)[0]][0]
        );

        return false;
    }

    render() {
        return (
            <form onSubmit={this.handleSubmit.bind(this)}>
                <div className="form-group">
                    <label htmlFor="username">To</label>
                    <input
                        className="form-control"
                        onChange={this.handleFieldChange.bind(this, 'recipient')}
                        name="username"
                        placeholder="username"
                    />
                </div>
                <div className="form-group">
                    <label htmlFor="amount">Amount</label>
                    <input
                        className="form-control"
                        onChange={this.handleFieldChange.bind(this, 'amount')}
                        name="amount"
                        placeholder="amount"
                    />
                </div>
                <input
                    className="btn btn-default"
                    type="submit"
                    value="Send"
                />
                <NotificationContainer/>
            </form>
        );
    }
}