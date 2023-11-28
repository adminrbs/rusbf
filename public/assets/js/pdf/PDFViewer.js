
function PDFViewer(size, orientation, title, header, logo, body, footer) {

    var url_path = 'http://127.0.0.1:8000';
    //var url_path = 'https://payroll.royal.lk/';
    pdfMake.fonts = {
        FM_Abhaya: {
            normal: url_path+'/fonts/FM_Abhaya.TTF',
            bold: url_path+'/fonts/FM_Abhaya.TTF',
            italics: url_path+'/fonts/FM_Abhaya.TTF',
            bolditalics: url_path+'/fonts/FM_Abhaya.TTF',
        },

        English_font: {
            normal: url_path+'/fonts/tahoma.ttf',
            bold: url_path+'/fonts/tahomabd.ttf',
            italics: url_path+'/fonts/tahoma.ttf',
            bolditalics: url_path+'/fonts/tahoma.ttf',
        },

        // download default Roboto font from cdnjs.com
        Roboto: {
            normal: 'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/fonts/Roboto/Roboto-Regular.ttf',
            bold: 'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/fonts/Roboto/Roboto-Medium.ttf',
            italics: 'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/fonts/Roboto/Roboto-Italic.ttf',
            bolditalics: 'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/fonts/Roboto/Roboto-MediumItalic.ttf'
        },

    }


    var pageContent = {
        pageSize: size,
        pageOrientation: orientation,
        header: title,
        /*defaultStyle: {
            font: 'FM_Abhaya'
        },Add custom font all elements*/
        footer: function (currentPage, pageCount) {
            return footerContext(footer, currentPage, pageCount);
        },
        content: [
            pageContext(logo, header, body),
        ],
        styles: {
            mainLayout: {}
        }
    };
    pdfMake.createPdf(pageContent).open();
    

}




function logoContext(logo) {
    if (logo != null && logo != undefined) {
        return {
            image: logo.image,
            width: logo.width,
            height: logo.height,
            alignment: logo.alignment,
        };
    }
    return {};
}


function headerContext(header) {
    if (header != null && header != undefined) {
        return header;
    }
    return [];
}



function bodyContext(body) {
    if (body != null && body != undefined) {
        return bodyContent(body);
    }
    return [];
}




function pageContext(logo, header, body) {

    var flag = 0;
    if (header.flag) {
        flag = 2;
    }

    return {
        style: 'mainLayout',
        layout: 'noBorders',
        table: {
            widths: ['100%'],
            headerRows: flag,
            body: [
                [logoContext(logo)],
                [{
                    stack: headerContext(header.content),

                }],
                [{
                    stack: bodyContext(body),
                }],

            ]
        },
        margin: [0, 0],
    }
}





function footerContext(footer, currentPage, pageCount) {
    return [
        {
            text: 'Page ' + currentPage.toString() + ' of ' + pageCount,
            alignment: footer[0].alignment,
            fontSize: footer[0].fontSize,
            color: footer[0].color,
            margin: footer[0].margin,
        },

    ];
}





function bodyContent(body) {
    var context = [];

    for (i = 0; i < body.length; i++) {
        if (body[i].customTable != undefined) {
            context.push(tableGroup(body[i]));
        } else {
            context.push(body[i]);
        }
    }
    return context;
}





var totalAmount = 0.0;
function tableGroup(table) {

    var array = [];
    if (table.customTable != undefined) {

        for (i3 = 0; i3 < table.customTable.length; i3++) {

            if (table.customTable[i3].header != undefined && table.customTable[i3].body != undefined && table.customTable[i3].sum != undefined && table.customTable[i3].op != undefined) {
                array.push(createGroup(table.customTable[i3]));

            }

            if (table.customTable[i3].total != undefined) {
                array.push(groupTotal(table.customTable[i3].total, totalAmount));
                totalAmount = 0.0;
            }
        }
    }
    return array;
}







function createGroup(table) {

    var tableBody = [];
    for (i5 = 0; i5 < table.header.length; i5++) {
        tableBody.push(table.header[i5]);
    }
    for (i6 = 0; i6 < table.body.length; i6++) {
        tableBody.push(table.body[i6]);
    }
    tableBody.push(tableSum(table));
    return {
        table: {
            widths: [80, '*', '*', '*'],
            headerRows: table.header.length,
            body: tableBody
        },

        margin: [0, 20],
    };
}





function groupTotal(total, amount) {

    total[0].text = total[0].text + parseFloat(amount).toFixed(2);
    return {
        table: {
            widths: ['*', 'auto'],
            headerRows: 1,
            body: [[{
                text: '',
                border: [false, false, false, false]
            }, total]],
            alignment: 'right'
        },
    }
}















function tableSum(table) {

    if (table != undefined) {
        if (table.sum != undefined && table.body != undefined && table.op != undefined) {
            console.log(table.sum.length);
            for (i2 = 0; i2 < table.sum.length; i2++) {
                const name = table.sum[i2].name;
                const index = table.sum[i2].index;
                var total = 0.0;
                for (ii2 = 0; ii2 < table.body.length; ii2++) {
                    total += parseFloat(table.body[ii2][index].text);
                }
                for (ii3 = 0; ii3 < table.op.length; ii3++) {
                    if (table.op[ii3].name == name) {
                        table.op[ii3].text = parseFloat(total).toFixed(2);
                    }
                }
            }
            totalAmount += total;
            return table.op;
        }
    }


}

