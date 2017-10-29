import './styles/main.scss';
import React, {Component} from 'react';

export default class Layout extends Component {

    constructor(props) {
        super(props);
    }

    componentDidMount() {

    }

    render() {
        return (
            <div className="wrapper">
                <nav className="navbar navbar-light bg-faded">
                    <a className="navbar-brand" href="/">Home</a>
                    <a className="navbar-brand" href="/personal">My page</a>
                </nav>
                <div id="content">
                    {this.props.children}
                </div>
            </div>
        );
    }
};