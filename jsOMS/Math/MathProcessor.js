/**
 * Standard library
 *
 * This library provides useful functionalities for the DOM and other manipulations.
 *
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @since      1.0.0
 */
(function (jsOMS) {
    "use strict";

    jsOMS.mathEvaluate = function(equation)
    {
        const stack = [];
        const postfix = jsOMS.shuntingYard(equation);
        const length = postfix.length;

        for(let i = 0; i < length; i++) {
            if (!isNaN(parseFloat(postfix[i])) && isFinite(postfix[i])) {
                stack.push(postfix[i]);
            } else {
                let a = jsOMS.parseValue(stack.pop());
                let b = jsOMS.parseValue(stack.pop());

                if(postfix[i] === '+') {
                    stack.push(a + b);
                } else if (postfix[i] === '-') {
                    stack.push(b - a);
                } else if (postfix[i] === '*') {
                    stack.push(a * b);
                } else if (postfix[i] === '/') {
                    stack.push(b / a);
                } else if (postfix[i] === '^') {
                    stack.push(Math.pow(b, a));
                }
            }
        }

        return stack.pop();
    };

    jsOMS.parseValue = function(value) 
    {
        return value.indexOf('.') === -1 ? parseInt(value) : parseFloat(value);
    }

    jsOMS.shuntingYard = function(equation)
    {
        const stack = [];
        const operators = {
            '^': {precedence: 4, order: 1},
            '/': {precedence: 3, order: -1},
            '*': {precedence: 3, order: -1},
            '+': {precedence: 3, order: -1},
            '-': {precedence: 3, order: -1},
        };
        let output = [];

        equation = equation.replace(/\s+/g, '');
        equation = equation.split(/([\+\-\*\/\^\(\)])/).filter(function (n) { return n !== '' }); 

        let length = equation.length;
        for(let i = 0; i < length; i++) {
            let token = equation[i];

            if (!isNaN(parseFloat(token)) && isFinite(token)) {
                output.push(token);
            } else if('^*/+-'.indexOf(token) !== -1) {
                let o1 = token;
                let o2 = stack[stack.length - 1];

                while ('^*/+-'.indexOf(o2) !== -1 && 
                    (
                        (operators[o1].order === -1 && operators[o1].precedence <= operators[o2].precedence)
                        || (operators[o1].order === 1 && operators[o1].precedence < operators[o2].precedence)
                    )
                ) {
                    output.push(stack.pop());
                    o2 = stack[stack.length - 1];
                }

                stack.push(o1);
            } else if(token === '(') {
                stack.push(token);
            } else if (token === ')') {
                while(stack[stack.length - 1] !== '(') {
                    output.push(stack.pop());
                }

                stack.pop();
            }
        }

        while(stack.length > 0) {
            output.push(stack.pop());
        }

        return output;
    };


}(window.jsOMS = window.jsOMS || {}));