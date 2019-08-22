// JavaScript Document

    function submitform (action, url) {

        arr = listoption('ctnlist');

        urlString = url + '?action=' + action + '&containers=' + arr;
        
        //<!-- var str = "act.php?act=input&page=" + page + "&list1=" + list1 + "&list2=" + list2; -->

        window.open(urlString, "_blank");
    }

	function input (id) {
		var elem, x, y, z, totalopt;
		var arr = new Array();
		elem = document.theform.elements;
		x = elem.length;
		z = document.getElementById(id);
		totalopt = z.length;

		for (y=0;y<x;y++) {
			if (elem[y].type == 'text' && trim(elem[y].value) != '') {
				arr = listoption(id);
				
				var add = true;
				 
				for (var i in arr) {
					if (arr[i].toUpperCase() == trim(elem[y].value.toUpperCase())) {
						add = false;
					}
				}

				if ( add == true) {
					clearall(id);
					var k = 0;
					var j = arr.length;
					
					arr[j] = trim(elem[y].value.toUpperCase());
					
					arr.sort();

					for (var i in arr) {
						z.options[k] = new Option(arr[i].toUpperCase());
						k++;
					}
				}
			}
		}
		
		cleartext();
        saveToCookie();
	}
	
    function fillOptions(id) {

        var cookieString = readCookie(id);
        var arr = cookieString.split(",");
        var selectElement = document.getElementById(id);

        arr = arr.filter(Boolean)
        clearall(id);

        k = 0;

        for (var i in arr) {
            selectElement.options[k] = new Option(arr[i].toUpperCase());
            k++;
        }

        console.log(arr);
    }

	function saveToCookie() {

     
        arr1 = listoption('ctnlist');
        arr2 = listoption('cache');

        createCookie('ctnlist', arr1, 365);
        createCookie('cache', arr2, 365);

	}

	function cleartext () {

		var elem, x, y;
		elem = document.theform.elements;
		x = elem.length;

		for (y=0;y<x;y++) {
			if (elem[y].type == 'text') {
				elem[y].value = '';
			}
		}
	}

	function listoption (id) {
	
		var x,y,z;
		var arr = new Array();
		
		y=0;
		z = document.getElementById(id);
		
		for (x=0;x<z.options.length;x++) {
			if (z[x].text != null) {
				arr[y] = trim(z[x].text);
				y++;
			}
		}
		
		return arr; 
	}
	
    function clearAllButton(id) {
        clearall(id);
        saveToCookie();
    }    

    function clearall (id) {
    
        var x,y,z;
        var arr = new Array();
        
        y=0;
        z = document.getElementById(id);
        
        for (var i in z) {
            z.remove(i);
        }

	}

    function clearSelectedButton(id) {
        clearselected(id);
        saveToCookie();
    } 

	function clearselected (id) {
		var x=document.getElementById(id);
		y = x.length;
		
		//if (x.selectedIndex >= 0) {//alert (x.selectedIndex);
		//	x.remove(x.selectedIndex);
		//}
		
		for (var i=(y-1);i>=0;i--) {
			if (x[i].selected == true) {
				x.remove(i);
			}
		}
	}
	
	function selectall (id) {
	
		var x=document.getElementById(id);
		y = x.length;
		
		for (var i=(y-1);i>=0;i--) {
			x[i].selected = true;
		}
	}
	
	function transferall(id1,id2) {
	
		var box1, box2;
		var arr1 = new Array();
		var arr2 = new Array();
		
		box1 = document.getElementById(id1);
		box2 = document.getElementById(id2);
		
		arr1 = listoption(id1);
		arr2 = listoption(id2);

		for (var j=0;j<arr1.length;j++) {
				
			var add = true;
			 
			for (var i in arr2) {
				if (arr2[i].toUpperCase() == arr1[j].toUpperCase()) {
					add = false;
				}
			}

			if ( add == true) {
				clearall(id2);
				var k = 0;
				var l = arr2.length;
				
				arr2[l] = arr1[j].toUpperCase();
				
				arr2.sort();

				for (var i in arr2) {
					box2.options[k] = new Option(arr2[i].toUpperCase());
					k++;
				}
			}
		}

        saveToCookie();
	
	}

	function selectedlist (id) {
	
		var box;
		var j = 0;
		var arr = new Array();
		
		box = document.getElementById(id);
		
		for (var i=0;i<box.length;i++) {
			if (box[i].selected == true) {
				arr[j] = box[i].text;
				j++;
			}
		}
	
		return arr;
	}


	function transferselected(id1,id2) {
	
		var box1, box2;
		var arr1 = new Array();
		var arr2 = new Array();
		
		box1 = document.getElementById(id1);
		box2 = document.getElementById(id2);
		
		arr1 = selectedlist(id1);
		arr2 = listoption(id2);

		for (var j=0;j<arr1.length;j++) {
				
			var add = true;
			 
			for (var i in arr2) {
				if (arr2[i].toUpperCase() == arr1[j].toUpperCase()) {
					add = false;
				}
			}

			if ( add == true) {
				clearall(id2);
				var k = 0;
				var l = arr2.length;
				
				arr2[l] = arr1[j].toUpperCase();
				
				arr2.sort();

				for (var i in arr2) {
					box2.options[k] = new Option(arr2[i].toUpperCase());
					k++;
				}
			}
		}

        saveToCookie();
	}
	
	function trim(s) {
		// Remove leading spaces and carriage returns
		while ((s.substring(0,1) == ' ') || (s.substring(0,1) == '\n') || (s.substring(0,1) == '\r')) {
			s = s.substring(1,s.length);
		}
		
		// Remove trailing spaces and carriage returns
		while ((s.substring(s.length-1,s.length) == ' ') || (s.substring(s.length-1,s.length) == '\n') || (s.substring(s.length-1,s.length) == '\r')) {
			s = s.substring(0,s.length-1);
		}
		
		return s;
	}

    function createCookie(name,value,days) {
        if (days) {
            var date = new Date();
            date.setTime(date.getTime()+(days*24*60*60*1000));
            var expires = "; expires="+date.toGMTString();
        }
        else var expires = "";
        document.cookie = name+"="+value+expires+"; path=/";
    }

    function readCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for(var i=0;i < ca.length;i++) {
            var c = ca[i];

            while (c.charAt(0)==' ') c = c.substring(1,c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
        }
        return null;
    }

    function eraseCookie(name) {
        createCookie(name,"",-1);
    }
	/**
	 * This array is used to remember mark status of rows in browse mode
	 */
	
	var marked_row = new Array;
	
	
	/**
	 * Sets/unsets the pointer and marker in browse mode
	 *
	 * @param   object    the table row
	 * @param   interger  the row number
	 * @param   string    the action calling this script (over, out or click)
	 * @param   string    the default background color
	 * @param   string    the color to use for mouseover
	 * @param   string    the color to use for marking a row
	 *
	 * @return  boolean  whether pointer is set or not
	 */
	
	function setPointer(theRow, theRowNum, theAction, theDefaultColor, thePointerColor, theMarkColor)
	{
		var theCells = null;
	
		// 1. Pointer and mark feature are disabled or the browser can't get the
		//    row -> exits
		if ((thePointerColor == '' && theMarkColor == '')
			|| typeof(theRow.style) == 'undefined') {
			return false;
		}
	
		// 2. Gets the current row and exits if the browser can't get it
		if (typeof(document.getElementsByTagName) != 'undefined') {
			theCells = theRow.getElementsByTagName('td');
		}
		else if (typeof(theRow.cells) != 'undefined') {
			theCells = theRow.cells;
		}
		else {
			return false;
		}
	
		// 3. Gets the current color...
		var rowCellsCnt  = theCells.length;
		var domDetect    = null;
		var currentColor = null;
		var newColor     = null;
		// 3.1 ... with DOM compatible browsers except Opera that does not return
		//         valid values with "getAttribute"
		if (typeof(window.opera) == 'undefined'
			&& typeof(theCells[0].getAttribute) != 'undefined') {
			currentColor = theCells[0].getAttribute('bgcolor');
			domDetect    = true;
		}
		// 3.2 ... with other browsers
		else {
			currentColor = theCells[0].style.backgroundColor;
			domDetect    = false;
		} // end 3
	
		// 3.3 ... Opera changes colors set via HTML to rgb(r,g,b) format so fix it
		if (currentColor.indexOf("rgb") >= 0) 
		{
			var rgbStr = currentColor.slice(currentColor.indexOf('(') + 1,
										 currentColor.indexOf(')'));
			var rgbValues = rgbStr.split(",");
			currentColor = "#";
			var hexChars = "0123456789ABCDEF";
			for (var i = 0; i < 3; i++)
			{
				var v = rgbValues[i].valueOf();
				currentColor += hexChars.charAt(v/16) + hexChars.charAt(v%16);
			}
		}
	
		// 4. Defines the new color
		// 4.1 Current color is the default one
		if (currentColor == ''
			|| currentColor.toLowerCase() == theDefaultColor.toLowerCase()) {
			if (theAction == 'over' && thePointerColor != '') {
				newColor              = thePointerColor;
			}
			else if (theAction == 'click' && theMarkColor != '') {
				newColor              = theMarkColor;
				marked_row[theRowNum] = true;
			}
		}
		// 4.1.2 Current color is the pointer one
		else if (currentColor.toLowerCase() == thePointerColor.toLowerCase()
				 && (typeof(marked_row[theRowNum]) == 'undefined' || !marked_row[theRowNum])) {
			if (theAction == 'out') {
				newColor              = theDefaultColor;
			}
			else if (theAction == 'click' && theMarkColor != '') {
				newColor              = theMarkColor;
				marked_row[theRowNum] = true;
			}
		}
		// 4.1.3 Current color is the marker one
		else if (currentColor.toLowerCase() == theMarkColor.toLowerCase()) {
			if (theAction == 'click') {
				newColor              = (thePointerColor != '')
									  ? thePointerColor
									  : theDefaultColor;
				marked_row[theRowNum] = (typeof(marked_row[theRowNum]) == 'undefined' || !marked_row[theRowNum])
									  ? true
									  : null;
			}
		} // end 4
	
		// 5. Sets the new color...
		if (newColor) {
			var c = null;
			// 5.1 ... with DOM compatible browsers except Opera
			if (domDetect) {
				for (c = 0; c < rowCellsCnt; c++) {
					theCells[c].setAttribute('bgcolor', newColor, 0);
				} // end for
			}
			// 5.2 ... with other browsers
			else {
				for (c = 0; c < rowCellsCnt; c++) {
					theCells[c].style.backgroundColor = newColor;
				}
			}
		} // end 5
	
		return true;
	} // end of the 'setPointer()' function
