import React, { Component } from 'react'
import './Auth.css'

export default class Auth extends Component {
    render() {
        return (
            <div className="auth-content">
                <div className="auth-modal">
                    <div className="developer-title">
                        React
                    </div>
                    <hr />
                    <div className="auth-title">Login </div>
                    <input type="text" class="form-control" id="name" placeholder="Nome"></input>
                    <input type="email" class="form-control" id="email" placeholder="nome@exemplo.com"></input>
                </div>
            </div>
        )
    }
}