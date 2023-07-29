/*******************************************************************************
 * Module responsible for adding transformation to the element on
 * move/scale/rotate operation It contains event handlers for drag start, stop
 * and moving
 *
 * @author Zaneta Szymanska <<ahref='mailto:z.szymanska@samsung.com'>z.szymanska@samsung.com</a>>
 *
 * **************************************************************************************
 *
 * Copyright (c) 2012 Samsung Electronics All Rights Reserved.
 *
 ******************************************************************************/
var transforms = (function() {
    "use strict";
    var that;

    return {
        /**
         * Event handler for drag start
         */
        start : function() {
            that = this;

            if (config.tool === "eraser") {
                raphaelPaint.removeShape(that);
            }

            if (config.tool === 'arrow') {
                raphaelPaint.setSelectedShape(that);

                // Animation for selected element
                that.animate({
                    "fill-opacity" : 0.4
                }, 500);

                switch (config.operation) {
                case "move":
                    // read last translation
                    that.odx = that.translate[0];
                    that.ody = that.translate[1];
                    break;

                case "scale":
                    // read last scale
                    that.osx = that.scale[0];
                    that.osy = that.scale[1];
                    break;

                default:
                    break;
                }
            }
        },

        /**
         * Event handler for moving
         *
         * @param dx {Number} shift by x axis from the start point
         * @param dy {Number} shift by y axis from the start point
         */
        move : function(dx, dy) {
            if (config.tool === 'arrow') {
                switch (config.operation) {
                case "move":
                    // change translation
                    that.translate[0] = that.odx + dx;
                    that.translate[1] = that.ody + dy;
                    break;

                case "scale":
                    // change scaling
                    if ((that.fig !== "circle") && (that.fig !== "square")) {
                        // for all figures except circle and square
                        that.scale[0] = that.osx + 10 * dx
                                / config.canvas.width;
                        that.scale[1] = that.osy + 10 * dy
                                / config.canvas.height;
                    } else {
                        // for circle and square
                        if (dx > dy) {
                            that.scale[0] = that.scale[1] = that.osx + 10 * dx
                                    / config.canvas.width;
                        } else {
                            that.scale[0] = that.scale[1] = that.osy + 10 * dy
                                    / config.canvas.height;
                        }
                    }
                    break;

                default:
                    break;
                }

                transforms.applyTransforms(that);
            }
        },

        /**
         * Event handler for drag end
         */
        up : function() {
            if (config.tool === 'arrow') {
                // Animation for selected element
                that.animate({
                    "fill-opacity" : 1
                }, 500);
            }
        },

        /**
         * Adds specified transformation to the element
         *
         * @param that {Object} Element to which the transformation is added
         */
        applyTransforms : function(that) {
            var str = "t" + that.translate[0] + "," + that.translate[1] + "r"
                    + that.rotate + "s" + that.scale[0] + "," + that.scale[1];
            that.transform(str);
            raphaelPaint.addBox();
        }
    };
}());