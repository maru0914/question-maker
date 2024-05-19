import {format, parseISO} from "date-fns";

const formatDatetime = (datetime) => format(
    parseISO(datetime),
    'yyyy-MM-dd HH:mm'
)


export {
    formatDatetime
};
