/*******************************************************************************
 * Main module responsible for logic of application, user interface
 *
 * @author Zaneta Szymanska <<ahref='mailto:z.szymanska@samsung.com'>z.szymanska@samsung.com</a>>
 *
 * **************************************************************************************
 *
 * Copyright (c) 2012 Samsung Electronics All Rights Reserved.
 *
 ******************************************************************************/
var raphaelPaint = (function() {
    "use strict";
    // Raphael 'canvas'
    var paper,
    // shapeDrawer Object (responsible for drawing shapes)
    drawer,
    // box for the selected shape
    lastbBox, selectedShape = null, colorPicker,
    // output for selected color in ColorPicker
    out,
    // DOM element (Raphael paper will be drawn inside it)
    container, exit, setColorPicker, changeColor, pickerInit, paint;

    /**
     * Closes application if possible
     */
    exit = function() {
        if (typeof tizen !== "undefined" && tizen.application) {
            if (confirm("Exit?")) {
                var app = tizen.application.getCurrentApplication();
                app.exit();
                tlib.logger.info("Application closed");
            }
        } else {
            alert("Not supported");
        }
    };

    /**
     * Sets specified color to color picker element
     *
     * @param color {String} Color to set to color picker
     */
    setColorPicker = function(color) {
        colorPicker.color(color);

        Raphael(function() {
            var clr = Raphael.color(color);
            out.value = clr;
            out.style.background = clr;
            out.style.color = Raphael.rgb2hsb(clr).b < 0.5 ? "#fff" : "#000";
        });
    };

    /**
     * Changes color of UI element and selected shape (if exist)
     *
     * @param color {String} Color to set
     */
    changeColor = function(color) {
        if (config.colorOption === "fillColor") {
            config.fillColor = color;
            $("#fill-color-label").css("background-color", color);
            if (selectedShape !== null) {
                selectedShape.attr({
                    fill : color
                });
            }
        } else {
            config.strokeColor = color;
            $("#stroke-color-label").css("background-color", color);
            if (selectedShape !== null) {
                selectedShape.attr({
                    stroke : color
                });
            }
        }
    };

    /**
     * Initializes color picker
     */
    pickerInit = function() {
        Raphael(function() {
            out = document.getElementById("output");

            // this is where colorpicker created
            colorPicker = Raphael.colorpicker(360, 160, 300, "#eee", document
                    .getElementById("color-picker"));

            out.onkeyup = function() {
                colorPicker.color(this.value);
            };
            // assigning onchange event handler
            var onchange = function() {
                return function(clr) {
                    var val = clr.replace(/^#(.)\1(.)\2(.)\3$/, "#$1$2$3");
                    out.value = val;
                    out.style.background = clr;
                    out.style.color = Raphael.rgb2hsb(clr).b < 0.5 ? "#fff"
                            : "#000";
                    changeColor(val);
                };
            };

            colorPicker.onchange = onchange();
        });
    };

    /**
     * Paints figure in specified place
     *
     * @param x {Number} x coordinate of specified position
     * @param y {Number} y coordinate of specified position
     */
    paint = function(x, y) {
        var shape = null;

        switch (config.tool) {
        case "rectangle":
            shape = drawer.drawRectangle(x, y);
            break;

        case "square":
            shape = drawer.drawSquare(x, y);
            break;

        case "triangle":
            shape = drawer.drawTriangle(x, y);
            break;

        case "circle":
            shape = drawer.drawCircle(x, y);
            break;

        case "ellipse":
            shape = drawer.drawEllipse(x, y);
            break;

        case "star":
            shape = drawer.drawStar(x, y);
            break;

        default:
            break;
        }

        if (shape) {
            raphaelPaint.setSelectedShape(shape);
        }
    };

    return {
        /**
         * Provides initialization for the app
         */
        initialize : function() {
            container = document.getElementById('canvas_container');
            paper = new Raphael(container, config.canvas.width,
                    config.canvas.height);

            drawer = new shapeDrawer(paper);

            // Initialize picker
            pickerInit();

            $("#rotate-div").hide();
            $("#color-picker").hide();

            $("#fill-color-label").css("background-color", config.fillColor);
            $("#stroke-color-label")
                    .css("background-color", config.strokeColor);

            $("#close").on("click", function() {
                exit();
            });

            $("#canvas_container")
                    .on(
                            "click",
                            function(e) {
                                e.preventDefault();
                                var rect = container.getBoundingClientRect(), x0 = e.pageX, y0 = e.pageY, x = x0
                                        - rect.left, y = y0 - rect.top, elem = paper
                                        .getElementByPoint(x0, y0);

                                if (config.tool === "arrow") {
                                    if (!elem) {
                                        if (selectedShape) {
                                            selectedShape = null;
                                            if (lastbBox) {
                                                lastbBox.remove();
                                            }
                                        }
                                    } else {
                                        raphaelPaint.setSelectedShape(elem);
                                    }
                                } else {
                                    paint(x, y);
                                }
                            });

            $(".transformations").on(
                    "click",
                    function() {
                        // set operation (move/scale/rotate)
                        config.operation = this.id;

                        // set rot-slider prop
                        if (this.id === "rotate") {
                            if (selectedShape) {
                                $("#rot-slider").val(selectedShape.rotate)
                                        .slider("refresh");
                            } else {
                                $("#rot-slider").val(0).slider("refresh");
                            }
                            $("#rotate-div").show();
                        } else {
                            $("#rotate-div").hide();
                        }
                    });

            $("#rot-slider").on("change", function() {
                if (selectedShape !== null) {
                    // rotate selected shape
                    selectedShape.rotate = $("#rot-slider").val();
                    transforms.applyTransforms(selectedShape);
                }
            });

            $("#cp-close").on("click", function() {
                // close color picker
                config.colorOption = null;
                $("#color-picker").hide();
            });

            $("[name=color]").on("click", function() {
                if (config.colorOption === this.id) {
                    // Close color picker
                    config.colorOption = null;
                    $("#color-picker").hide();
                    $(this).prop("checked", false);
                } else {
                    if (config.colorOption === null) {
                        // Open color picker
                        $("#color-picker").show();
                    }

                    config.colorOption = this.id;
                    $(this).prop("checked", true);
                    setColorPicker(config[this.id]);
                }
            });

            $("[name=options]").on("click", function() {
                config.tool = this.id;

                switch (config.tool) {
                case "arrow":
                    if ($("#move-scale-rotate").is(":visible")) {
                        $("#move-scale-rotate").hide();
                    } else {
                        $("#move-scale-rotate").show();
                    }
                    break;

                case "clear":
                    $("#move-scale-rotate").hide();
                    paper.clear();

                    if (lastbBox) {
                        lastbBox.remove();
                    }

                    if (selectedShape) {
                        selectedShape = null;
                    }
                    break;

                default:
                    $("#move-scale-rotate").hide();
                    break;
                }
            });
        },

        /**
         * Removes specified element (figure) from canvas
         *
         * @param elem {Object} Element to be removed
         */
        removeShape : function(elem) {
            elem.remove();
            if (lastbBox) {
                lastbBox.remove();
            }
        },

        /**
         * Removes drawn previously box, gets bounding box for selectedShape
         * object and draws it
         */
        addBox : function() {
            if (lastbBox) {
                lastbBox.remove();
            }
            var bBox = selectedShape.getBBox();
            lastbBox = paper.rect(bBox.x, bBox.y, bBox.width, bBox.height)
                    .attr({
                        stroke : "#9a9a9a"
                    });
        },

        /**
         * Sets element as selected, sets proper properties of the UI elements
         *
         * @param that {Object} Selected element
         */
        setSelectedShape : function(that) {
            selectedShape = that;
            raphaelPaint.addBox();

            $("#rot-slider").val(that.rotate).slider("refresh");
            config.fillColor = that.attr("fill");
            config.strokeColor = that.attr("stroke");
            $("#fill-color-label").css("background-color", config.fillColor);
            $("#stroke-color-label")
                    .css("background-color", config.strokeColor);

            if (config.colorOption !== null) {
                if (config.colorOption === "fillColor") {
                    setColorPicker(config.fillColor);
                } else {
                    setColorPicker(config.strokeColor);
                }
            }
        }
    };
}());