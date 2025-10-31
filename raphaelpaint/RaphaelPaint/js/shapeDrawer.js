/*******************************************************************************
 * Module responsible for drawing shapes: circle, ellipse, triangle, square, rectangle and star
 * It sets also some common, initial properties of newly created figures
 *
 * @author Zaneta Szymanska <<ahref='mailto:z.szymanska@samsung.com'>z.szymanska@samsung.com</a>>
 *
 * **************************************************************************************
 *
 * Copyright (c) 2012 Samsung Electronics All Rights Reserved.
 *
 ******************************************************************************/
/**
 * @param raph {Object} Object on which to draw
 */
"use strict";
var shapeDrawer = function(raph) {
    var paper = raph, setProperties;

    /**
     * Sets some common properties of newly created shapes like: fill and stroke color, transformation prop and event handlers
     * @param elem {Object} Newly created shape
     * @returns elem {Object} Object with set properties
     */
    setProperties = function(elem) {
        elem.attr({
            // Attributes of the element
            "fill" : config.fillColor,
            "stroke" : config.strokeColor
        });

        // Initial values of applied transforms
        elem.translate = [ 0, 0 ];
        elem.scale = [ 1, 1 ];
        elem.rotate = 0;

        // Sets event handlers for moving, drag start and end
        elem.drag(transforms.move, transforms.start, transforms.up);

        return elem;
    };

    /**
     * Draws a circle
     * @param x {Number} x coordinate of the circle's center
     * @param y {Number} y coordinate of the circle's center
     * @returns {Object} Newly created figure
     */
    this.drawCircle = function(x, y) {
        var circle;

        circle = paper.circle(x, y, 30);
        circle.fig = "circle";

        return setProperties(circle);
    };

    /**
     * Draws a ellipse
     * @param x {Number} x coordinate of the ellipse's center
     * @param y {Number} y coordinate of the ellipse's center
     * @returns {Object} Newly created figure
     */
    this.drawEllipse = function(x, y) {
        var ellipse;

        ellipse = paper.ellipse(x, y, 60, 30);
        ellipse.fig = "ellipse";

        return setProperties(ellipse);
    };

    /**
     * Draws a triangle
     * @param x {Number} x coordinate of the first point on the path forming the figure
     * @param y {Number} y coordinate of the first point on the path forming the figure
     * @returns {Object} Newly created figure
     */
    this.drawTriangle = function(x, y) {
        var str, triangle;

        str = "M " + x + " " + y + " l 30 -60 l 30 60 z";
        triangle = paper.path(str);
        triangle.fig = "triangle";

        return setProperties(triangle);
    };

    /**
     * Draws a square
     * @param x {Number} x coordinate of the square's top left corner
     * @param y {Number} y coordinate of the square's top left corner
     * @returns {Object} Newly created figure
     */
    this.drawSquare = function(x, y) {
        var square;

        square = paper.rect(x, y, 50, 50);
        square.fig = "square";

        return setProperties(square);
    };

    /**
     * Draws a rectangle
     * @param x {Number} x coordinate of the rectangle's top left corner
     * @param y {Number} y coordinate of the rectangle's top left corner
     * @returns {Object} Newly created figure
     */
    this.drawRectangle = function(x, y) {
        var rect;

        rect = paper.rect(x, y, 80, 50);
        rect.fig = "rectangle";

        return setProperties(rect);
    };

    /**
     * Draws a star
     * @param x {Number} x coordinate of the first point on the path forming the figure
     * @param y {Number} y coordinate of the first point on the path forming the figure
     * @returns {Object} Newly created figure
     */
    this.drawStar = function(x, y) {
        var str, star;

        str = "M " + x + " " + y;
        str += " l 14 20 l 24 0 l -15 19 l 8 23 l -23 -8 l -20 14 l 0 -24 l -20 -14 l 24 -7 z";

        star = paper.path(str);
        star.fig = "star";

        return setProperties(star);
    };
};