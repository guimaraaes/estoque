import React, {Component} from 'react';
import ReactDOM from 'react-dom';
import 'bootstrap/dist/css/bootstrap.min.css';
import './index.css';
import {HashRouter} from 'react-router-dom'

import App from './App';


class Ap extends Component {
  render() {
    return (
          <HashRouter>
          <App />
          </HashRouter>
        );
    }
}

export default Ap;

if (document.getElementById('app')) {
  ReactDOM.render(<Ap/>, document.getElementById('app'));
}

