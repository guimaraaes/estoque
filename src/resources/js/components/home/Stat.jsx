import React from 'react'
import './Stat.css'

export default props => {
    return (
        <div className="stat" style={props.color}>
            <div className="stat-icon">
                <i className={props.icon}></i>
            </div>
            <div className="stat-info">
                <span className="stat-title">{props.title}</span>
                <span className="stat-value">{props.value}</span>
            </div>
        </div>
    )
}

