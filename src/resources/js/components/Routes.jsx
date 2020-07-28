import React from 'react'
import { Switch, Route, Redirect} from 'react-router-dom'

import Home from './home/Home'
import Sale from './sale/Sale'
import Auth from './auth/Auth'

export default props => {
    return (
        <Switch>
            <Route  exact path="/" component={Home} />
            <Route path="/sale" component={Sale} />
            <Route path="/auth" component={Auth} />
            <Redirect from="*" to="/" />
        </Switch>
    )

}