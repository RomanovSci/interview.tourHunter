import React from 'react';
import {
    Router,
    Route,
    RouterState,
    IndexRoute,
    browserHistory
} from 'react-router';
import Layout from './Layout';

/** Pages */
import Home from './components/pages/Home';
import Login from './components/pages/Login';
import Personal from './components/pages/Personal';
import NotFound from './components/pages/NotFound';

/** Router */
export default <Router history={browserHistory}>
    <Route path="/" component={Layout}>
        <IndexRoute component={Home}/>
        <Route path="/login" component={Login}/>
        <Route path="/personal" components={Personal}/>

        <Route path="*" component={NotFound}/>
    </Route>
</Router>;